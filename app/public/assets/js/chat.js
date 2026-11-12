/**
 * Studio Inspirasi — Alpine app. Satu komponen menggerakkan sidebar nav,
 * view utama (hash-routed), dan panel Processes kanan. Polling daftar
 * session tiap 3 detik; pesan run dipoll selama project detail terbuka
 * atau ada run aktif.
 */

/* global CC_DATA, lucide */

function ccApi(method, path, formData, timeoutMs) {
	const ctl = new AbortController();
	const t = setTimeout(() => ctl.abort(), timeoutMs || 45000);
	return fetch(CC_DATA.restUrl + path, {
		method: method,
		headers: { 'X-WP-Nonce': CC_DATA.restNonce },
		body: formData || undefined,
		signal: ctl.signal,
	}).then(async function (res) {
		clearTimeout(t);
		const data = await res.json().catch(() => null);
		if (!res.ok) {
			throw new Error((data && data.message) || 'Permintaan gagal (' + res.status + ').');
		}
		return data;
	}).catch(function (e) {
		clearTimeout(t);
		throw (e && e.name === 'AbortError') ? new Error('Permintaan timeout — server lambat merespons.') : e;
	});
}

function ccPost(path, fields) {
	const fd = new FormData();
	Object.keys(fields || {}).forEach((k) => {
		const v = fields[k];
		fd.append(k, (v !== null && typeof v === 'object') ? JSON.stringify(v) : v);
	});
	return ccApi('POST', path, fd);
}

function ccEscape(s) {
	return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

/**
 * Kartu review EDL — dipakai markup yang di-inject server-side lewat
 * x-html (Alpine v3 meng-inisialisasi node injeksi via MutationObserver).
 * Data awal dibaca dari JSON embed .cc-edl-data; edits ditahan lokal
 * sampai user menekan Terapkan / Susun ulang / Batalkan.
 */
function ccEdlCard(el) {
	let d = {};
	try { d = JSON.parse(el.querySelector('.cc-edl-data').textContent || '{}'); } catch (e) {}
	const segs = (d.segs || []).map(function (s) {
		return { label: s.label || '', dur: +s.dur || 0, items: (s.items || []).map(function (it) { return Object.assign({}, it); }) };
	});
	return {
		segs: segs,
		brolls: (d.catalog && d.catalog.brolls) || [],
		sfxs: (d.catalog && d.catalog.sfxs) || [],
		jobId: d.job_id || 0,
		state: d.state || 'pending',
		busy: false, err: '', note: '', open: '',
		fmtT(sec) {
			sec = Math.max(0, +sec || 0);
			const m = Math.floor(sec / 60), s = (sec % 60);
			return m + ':' + (s < 10 ? '0' : '') + s.toFixed(1);
		},
		togVid(si, ii) {
			const k = si + '-' + ii;
			this.open = this.open === k ? '' : k;
			this.$nextTick(function () {
				const v = el.querySelector('.cc-edl-vid video');
				if (v && v.currentTime < 0.05) { try { v.currentTime = 0.05; } catch (e) {} }
			});
		},
		delItem(si, ii) { this.segs[si].items.splice(ii, 1); },
		addItem(si) {
			const b = this.brolls[0];
			if (!b) { return; }
			this.segs[si].items.push({
				broll_id: b.id, name: b.name, tl_start: 0,
				dur: Math.min(4, b.dur || 4), src_start: 0,
				sfx_id: '', sfx_name: '', reason: 'ditambahkan manual',
				video: b.video, thumb: '',
			});
		},
		swapBroll(si, ii) {
			const it = this.segs[si].items[ii];
			const b = this.brolls.find(function (x) { return x.id === it.broll_id; });
			if (!b) { return; }
			it.name = b.name; it.video = b.video; it.thumb = '';
			if (it.src_start + it.dur > b.dur) { it.dur = Math.max(0.3, b.dur - it.src_start); }
		},
		payload() {
			const out = {};
			this.segs.forEach(function (s, si) {
				out[si] = s.items.map(function (it) {
					return {
						broll_id: it.broll_id,
						timeline_start: +it.tl_start || 0,
						duration: +it.dur || 0,
						source_start: +it.src_start || 0,
						sfx_id: it.sfx_id || '',
						reason: it.reason || '',
					};
				});
			});
			return out;
		},
		async act(action) {
			if (this.busy || 'pending' !== this.state) { return; }
			this.busy = true; this.err = '';
			try {
				const r = await ccPost('/control/edl-review', {
					job_id: this.jobId, action: action, note: this.note, items: this.payload(),
				});
				if ('applied' === r.state || 'cancelled' === r.state) { this.state = r.state; }
				if ('pending' === r.state && 'replan' === action) {
					// Kartu baru diposting server — poll menampilkannya.
					this.state = 'replaced';
				}
			} catch (e) { this.err = e.message; }
			this.busy = false;
		},
		apply() { this.act('apply'); },
		replan() { this.act('replan'); },
		cancelReview() { this.act('cancel'); },
	};
}

function ccChat() {
	return {
		sessions: [], activeId: 0, activeTitle: '', activeProject: '',
		messages: [], loading: false,
		error: '',
		hasActive: false, activeJobId: 0, jobDetail: '',
		statusOpenai: false, statusConcat: false, statusHint: '',
		dark: false, sideOpen: true, rightOpen: true,
		view: 'projects',
		navItems: [
			{ view: 'projects', icon: 'folder-kanban', label: 'Projects' },
			{ view: 'templates', icon: 'layout-template', label: 'Templates' },
			{ view: 'brolls', icon: 'clapperboard', label: 'B-Rolls' },
			{ view: 'sfx', icon: 'volume-2', label: 'Sound Effects' },
			{ view: 'settings', icon: 'settings-2', label: 'Settings' },
		],
		_typing: {}, _seenAtOpen: 0,

		/* Search + pagination per tabel — state disimpan per scope supaya
		 * query tidak bocor antar view. */
		pg: {
			projects: { q: '', page: 1 },
			templates: { q: '', page: 1 },
			lib: { q: '', page: 1 },
		},
		perPage: 10,

		tblMatch(row, q) {
			const hay = [row.title, row.name, row.project, row.path, row.desc]
				.filter(Boolean).join(' ').toLowerCase();
			return hay.includes(String(q || '').toLowerCase().trim());
		},
		tblFiltered(rows, q) {
			if (!String(q || '').trim()) { return rows; }
			return rows.filter((r) => this.tblMatch(r, q));
		},
		tblCount(rows, q) { return this.tblFiltered(rows, q).length; },
		tblPages(rows, q) { return Math.max(1, Math.ceil(this.tblCount(rows, q) / this.perPage)); },
		tblRows(rows, pg) {
			const f = this.tblFiltered(rows, pg.q);
			const pages = this.tblPages(rows, pg.q);
			if (pg.page > pages) { pg.page = pages; }
			if (pg.page < 1) { pg.page = 1; }
			return f.slice((pg.page - 1) * this.perPage, pg.page * this.perPage);
		},

		init() {
			try { this.dark = localStorage.getItem('cc_dark') === '1'; } catch (e) {}
			// Panel Processes default hidden — terbuka otomatis saat run dimulai.
			try { this.rightOpen = localStorage.getItem('cc_right') === '1'; } catch (e) {}
			// Riwayat proses disimpan di sessionStorage — bertahan saat
			// refresh, hilang saat tab/browser benar-benar ditutup.
			try { this.procSeen = JSON.parse(sessionStorage.getItem('cc_procs') || '{}') || {}; } catch (e) { this.procSeen = {}; }
			this._seenAtOpen = Date.now();
			// Prefill folder bahan dari default Settings (hanya bila field kosong).
			this.ctl.f.broll_dir = this.ctl.f.broll_dir || (CC_DATA.brollDir || '');
			this.ctl.f.sfx_dir = this.ctl.f.sfx_dir || (CC_DATA.sfxDir || '');
			this.ctl.copyRoots = (CC_DATA.copyRoots || []);
			this.loadStatus();
			this.loadSessions();
			if (!location.hash) {
				try { history.replaceState(null, '', '#/projects'); } catch (e) {}
			}
			this.applyHash();
			window.addEventListener('hashchange', () => this.applyHash());
			setInterval(() => { this.pollMessages(); this.loadSessions(); }, 3000);
			setInterval(() => { this.loadStatus(); }, 60000);
			this.$nextTick(() => this.icons());
		},

		icons() { if (window.lucide && lucide.createIcons) { lucide.createIcons(); } },
		threadEl() { return this.$el.querySelector('#cc-thread'); },
		scrollBottom() { const t = this.threadEl(); if (t) { t.scrollTop = t.scrollHeight; } },
		onScroll() {
			const t = this.threadEl();
			if (t && t.scrollTop < 40 && this.hasMore && !this._loadingOlder) {
				this.loadOlder();
			}
			this.updateJump();
		},

		/* ---------------- routing ---------------- */

		nav(target) {
			const h = '#/' + target;
			if (location.hash === h) {
				this.applyHash();
			} else {
				location.hash = h;
			}
		},

		parseHash() {
			const seg = (location.hash || '').replace(/^#\/?/, '').split('/').filter(Boolean);
			const v = seg[0] || 'projects';
			if (v === 'project' && seg[1]) { return { view: 'project', id: parseInt(seg[1], 10) || 0 }; }
			const valid = ['create', 'projects', 'templates', 'brolls', 'sfx', 'settings'];
			return { view: valid.includes(v) ? v : 'projects', id: 0 };
		},

		applyHash() {
			const r = this.parseHash();
			const sameProject = 'project' === r.view && 'project' === this.view && this.activeId === r.id;
			this.view = r.view;
			switch (r.view) {
				case 'create':
					if (!this.ctl.templates.length) { this.loadTemplates(); }
					break;
				case 'project':
					if (r.id && !sameProject) { this.openSession(r.id); }
					break;
				case 'templates':
					this.loadTplList();
					if (!this.ctl.templates.length) { this.loadTemplates(); }
					break;
				case 'brolls':
					this.loadLibrary('broll');
					break;
				case 'sfx':
					this.loadLibrary('sfx');
					break;
				case 'settings':
					this.loadSettings();
					break;
			}
			this.$nextTick(() => this.icons());
		},

		navActive(v) {
			if ('projects' === v) { return 'projects' === this.view || 'project' === this.view; }
			return this.view === v;
		},

		viewTitle() {
			const t = {
				create: 'Create New', projects: 'Projects', templates: 'Templates',
				brolls: 'B-Rolls', sfx: 'Sound Effects', settings: 'Settings',
			};
			if ('project' === this.view) {
				return (this.activeTitle || 'Project').replace(/-/g, ' ');
			}
			return t[this.view] || 'Studio Clipper';
		},

		newRun() {
			this.nav('create');
		},

		/* ---------------- status ---------------- */

		async loadStatus() {
			try {
				const s = await ccApi('GET', '/status');
				this.statusOpenai = !!s.openai.configured;
				this.statusConcat = !!(s.concat && s.concat.ok);
				this.statusHint = this.statusConcat
					? 'Concat ' + (s.concat.concat || '') + ' · API ' + (s.concat.apiVersion || '')
					: ((s.concat && s.concat.error) || 'Concat tidak terhubung — aktifkan Settings › Automation.');
			} catch (e) { this.statusConcat = false; }
		},

		/* ---------------- sessions / projects ---------------- */

		get runningSessions() {
			return this.sessions.filter((s) => s.active);
		},

		// Proses yang pernah tampil selama sesi browser ini — aktif +
		// selesai. Panel menampilkan semuanya sampai browser ditutup.
		procSeen: {}, _wasActive: false,

		get procItems() {
			return Object.values(this.procSeen).sort((a, b) => b.id - a.id);
		},

		procFailed(s) {
			const cs = s.clips || [];
			return !cs.length || cs.some((c) => c.status === 'failed' || c.status === 'cancelled');
		},

		// Baris status klip dari /sessions (meta.kind='clip') — checklist
		// progress di tengah. Sumbernya sessions, bukan messages, supaya
		// tidak terpotong window 40 pesan pada run multi-segmen besar.
		get activeClips() {
			const s = this.sessions.find((x) => x.id === this.activeId);
			return (s && s.clips) || [];
		},

		get doneClips() {
			return this.activeClips.filter((c) => c.status === 'done');
		},

		// Kartu review EDL yang masih menunggu — satu-satunya jenis
		// 'proses' yang tetap di tengah karena butuh keputusan user.
		get reviewMsgs() {
			return this.messages.filter((m) => m.role === 'review' && m.status === 'pending');
		},

		clipModal: { open: false, title: '', items: [], sessionId: 0 },

		openClips(s) {
			this.clipModal = {
				open: true,
				title: (s.title || '').replace(/-/g, ' '),
				items: s.clips || [],
				sessionId: s.id,
			};
			this.$nextTick(() => this.icons());
		},

		async loadSessions() {
			try {
				const d = await ccApi('GET', '/sessions');
				this.sessions = d.items || [];
				const cur = this.sessions.find((x) => x.id === this.activeId);
				if (cur && cur.project !== undefined) { this.activeProject = cur.project || ''; }
				// Simpan proses yang pernah aktif ke riwayat panel — data
				// (tasks, clips) dipertahankan sampai browser ditutup.
				const ids = {};
				this.sessions.forEach((s) => { ids[s.id] = true; });
				Object.keys(this.procSeen).forEach((id) => {
					if (!ids[id]) { delete this.procSeen[id]; }
				});
				this.sessions.forEach((s) => {
					const prev = this.procSeen[s.id];
					if (s.active || prev) {
						this.procSeen[s.id] = Object.assign({}, prev || {}, s, {
							tasks: (s.tasks && s.tasks.length) ? s.tasks : ((prev && prev.tasks) || []),
						});
					}
				});
				try { sessionStorage.setItem('cc_procs', JSON.stringify(this.procSeen)); } catch (e) {}
				// Auto-hide: saat tidak ada job aktif lagi setelah sebelumnya
				// ada, panel Processes menutup sendiri.
				const anyActive = this.sessions.some((s) => s.active);
				if (this._wasActive && !anyActive) {
					this.rightOpen = false;
					try { localStorage.setItem('cc_right', '0'); } catch (e) {}
				}
				this._wasActive = anyActive;
			} catch (e) { /* retry next tick */ }
		},

		viewSession(id) {
			if (!id) { return; }
			this.nav('project/' + id);
		},

		async openSession(id) {
			if (!id) { return; }
			this.activeId = id;
			this.error = '';
			this.loading = true;
			this.messages = [];
			this.oldestId = 0;
			this.hasMore = false;
			this.showJump = false; // reset — jangan warisi state sesi sebelumnya
			try {
				const d = await ccApi('GET', '/sessions/' + id + '/messages');
				this.activeTitle = d.title || 'Project baru';
				this.activeProject = d.project || '';
				this.messages = this.orderMsgs((d.items || []).map((m) => this.adopt(m)));
				this.oldestId = d.oldest_id || 0;
				this.hasMore = !!d.has_more;
				this.hasActive = !!d.has_active;
				this.activeJobId = d.active_job_id || 0;
				this.jobDetail = d.job_detail || '';
				// Anchor at the user's last message (Gemini-style) — the
				// AI reply below is reached via the ↓ jump button.
				this._stickBottom = true;
				this.$nextTick(() => {
					this.icons();
					this.scrollToLastUser();
					setTimeout(() => this.scrollToLastUser(), 250);
					this.updateJump();
				});
			} catch (e) { this.error = e.message; }
			this.loading = false;
		},

		/* ---------------- rename / delete modal ---------------- */
		modal: { open: false, id: 0, title: '', busy: false, confirm: false },

		openRename(s) {
			this.modal = { open: true, id: s.id, title: s.title, busy: false, confirm: false };
			this.$nextTick(() => this.icons());
		},

		async saveRename() {
			if (this.modal.busy || !this.modal.title.trim()) { return; }
			this.modal.busy = true;
			try {
				await ccPost('/sessions/' + this.modal.id + '/rename', { title: this.modal.title.trim() });
				const s = this.sessions.find((x) => x.id === this.modal.id);
				if (s) { s.title = this.modal.title.trim(); }
				if (this.activeId === this.modal.id) { this.activeTitle = this.modal.title.trim(); }
				this.modal.open = false;
			} catch (e) { this.error = e.message; }
			this.modal.busy = false;
		},

		askDelete() {
			if (!this.modal.busy) { this.modal.confirm = true; }
		},

		async confirmDelete() {
			if (this.modal.busy) { return; }
			this.modal.busy = true;
			try {
				await ccApi('DELETE', '/sessions/' + this.modal.id);
				this.modal.open = false;
				this.sessions = this.sessions.filter((x) => x.id !== this.modal.id);
				if (this.activeId === this.modal.id) {
					this.activeId = 0;
					this.activeTitle = '';
					this.activeProject = '';
					this.messages = [];
					this.nav('projects');
				}
			} catch (e) { this.error = e.message; }
			this.modal.busy = false;
		},

		fmtDate(s) {
			if (!s) { return ''; }
			const d = new Date(String(s).replace(' ', 'T'));
			if (isNaN(d.getTime())) { return s; }
			const sameYear = d.getFullYear() === new Date().getFullYear();
			return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: sameYear ? undefined : 'numeric' })
				+ ' · ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
		},

		/* ---------------- control mode ---------------- */
		ctl: {
			templates: [], tplError: '', copyRoots: [], step: 0,
			browseOpen: false, browseField: 'file', browseMode: 'file',
			browse: { path: '', parent: '', dirs: [], files: [] },
			f: {
				workflow: 'clip', src: 'template', template: '', template_label: '', aspect: '9:16',
				file: '', vo_file: '', broll_dir: '', sfx_dir: '', broll_vision: false,
				broll_pacing: 'calm', broll_prompt: '', broll_motion_in: 'slide', broll_motion_out: 'fade',
				edl_review: true, hook_ai: true, extra_prompt: '',
				mode: 'manual', moment_count: 3, moment_min: 30, moment_max: 90,
				silence_cut: false, silence_db: -35, silence_min: 0.5, silence_pad: 0.1, use_sfx: false,
				segments: [{ start: '0:00', end: '0:10' }], name: '', action: 'handoff',
				output_name: '', dest_dir: '', srt: '', cap_lang: 'id', local_stt: true,
			},
			submitting: false, running: false, error: '', sessionId: 0,
			scan: {},
		},

		ctlStepLabels() {
			const wf = this.ctl.f.workflow;
			if (wf === 'assembly') { return ['Sumber & VO', 'B-Roll & SFX', 'Arahan AI', 'Proyek']; }
			if (wf === 'broll') { return ['Sumber', 'B-Roll & Sub', 'Segmen & AI', 'Proyek']; }
			return ['Sumber', 'Subtitle', 'Segmen', 'Proyek'];
		},

		async loadTemplates() {
			this.ctl.tplError = '';
			try {
				const d = await ccApi('GET', '/control/templates');
				this.ctl.templates = d.items || [];
			} catch (e) { this.ctl.tplError = 'Template tidak bisa dimuat: ' + e.message; }
			this.$nextTick(() => this.icons());
		},

		ctlTemplateChange() {
			const t = this.ctl.templates.find((x) => x.path === this.ctl.f.template);
			this.ctl.f.template_label = t ? t.name : '';
		},

		tplDims(t) {
			const m = this.ctl.templates.find((x) => x.path === t.path);
			return m && m.width ? m.width + '×' + m.height : '';
		},

		createFromTemplate(t) {
			this.ctl.f.src = 'template';
			this.ctl.f.template = t.path;
			this.ctlTemplateChange();
			this.nav('create');
		},

		ctlSuggestName() {
			if (this.ctl.f.name) { return; }
			const srcPath = this.ctl.f.workflow === 'assembly' ? this.ctl.f.vo_file : this.ctl.f.file;
			const base = ((srcPath || '').split('/').pop() || '').replace(/\.[^.]+$/, '');
			if (base) { this.ctl.f.name = 'reel-' + base.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, ''); }
		},

		ctlFieldGet(field) {
			if (field.startsWith('lib.')) { return this.lib[field.slice(4)] || ''; }
			if (field.startsWith('st.')) { return this.st.f[field.slice(3)] || ''; }
			return (this.ctl.f[field] || '');
		},
		ctlFieldSet(field, val) {
			// Daftar multi-folder — hasil browse ditambahkan, bukan menimpa.
			if (field === 'st.copy_roots') {
				const cur = (this.st.f.copy_roots || '').replace(/[\s;]+$/, '');
				this.st.f.copy_roots = (cur ? cur + '; ' : '') + val;
				return;
			}
			if (field.startsWith('lib.')) {
				if ('dir' === field.slice(4)) {
					this.lib.dirs[this.lib.kind] = val;
					this.loadLibrary(this.lib.kind);
				} else {
					this.lib[field.slice(4)] = val;
				}
				return;
			}
			if (field.startsWith('st.')) { this.st.f[field.slice(3)] = val; return; }
			this.ctl.f[field] = val;
			if (['sfx_dir', 'broll_dir'].includes(field)) { this.ctlScanFolder(field); }
		},

		// Scrape otomatis: tampilkan hitung isi folder begitu dipilih.
		async ctlScanFolder(field) {
			const dir = (this.ctl.f[field] || '').trim();
			if (!dir) { delete this.ctl.scan[field]; return; }
			try {
				const d = await ccApi('GET', '/control/folder?path=' + encodeURIComponent(dir));
				this.ctl.scan[field] = (d.files || []).length + ' file · ' + (d.dirs || []).length + ' subfolder terdeteksi';
			} catch (e) { this.ctl.scan[field] = 'Tidak bisa membaca folder ini.'; }
		},

		ctlBrowseOpen(field = 'file', mode = 'file') {
			this.ctl.browseField = field;
			this.ctl.browseMode = mode;
			this.ctl.browseOpen = true;
			const curVal = this.ctlFieldGet(field);
			let start = (CC_DATA.workspace || '').replace(/\/+$/, '') + '/Assets';
			if (curVal && curVal.startsWith('/')) {
				start = mode === 'dir' ? curVal : curVal.replace(/\/[^/]*$/, '');
			}
			this.ctlBrowseTo(start);
		},

		async ctlBrowseTo(path) {
			if (!path) { return; }
			try {
				const d = await ccApi('GET', '/control/folder?path=' + encodeURIComponent(path));
				this.ctl.browse = { path: d.path, parent: d.parent || '', dirs: d.dirs || [], files: d.files || [], error: '' };
			} catch (e) {
				// Keep the modal open and surface the error inside it — closing
				// here makes the popup flicker-vanish with no visible reason.
				this.ctl.browse = { path: path, parent: '', dirs: [], files: [], error: e.message };
			}
			this.$nextTick(() => this.icons());
		},

		ctlPick(path) {
			this.ctlFieldSet(this.ctl.browseField || 'file', path);
			this.ctl.browseOpen = false;
			this.ctlSuggestName();
		},

		ctlPickDir() {
			if (this.ctl.browse.path) {
				this.ctlFieldSet(this.ctl.browseField || 'broll_dir', this.ctl.browse.path);
			}
			this.ctl.browseOpen = false;
		},

		ctlSize(bytes) {
			if (!bytes) { return ''; }
			const mb = bytes / 1048576;
			return mb >= 1 ? mb.toFixed(1) + ' MB' : Math.round(bytes / 1024) + ' KB';
		},

		// "6:02" | "1:02:30" | "362" | "2:30.5" → seconds (null bila tak valid)
		ccParseTime(s) {
			const t = String(s).trim();
			if (!t) { return null; }
			if (/^\d+(\.\d+)?$/.test(t)) { return parseFloat(t); }
			let m = t.match(/^(\d{1,3}):([0-5]?\d(?:\.\d+)?)$/);
			if (m) { return parseInt(m[1], 10) * 60 + parseFloat(m[2]); }
			m = t.match(/^(\d{1,2}):([0-5]?\d):([0-5]?\d(?:\.\d+)?)$/);
			if (m) { return parseInt(m[1], 10) * 3600 + parseInt(m[2], 10) * 60 + parseFloat(m[3]); }
			return null;
		},

		async submitControl() {
			if (this.ctl.submitting || this.hasActive) { return; }
			this.ctl.error = '';
			const f = this.ctl.f;
			if (!f.name.trim()) { this.ctl.error = 'Nama proyek wajib diisi.'; return; }
			if (f.src === 'template' && !f.template) { this.ctl.error = 'Pilih template dulu.'; return; }
			if (f.workflow === 'assembly') {
				if (!f.vo_file.trim()) { this.ctl.error = 'File audio Voice Over wajib diisi.'; return; }
				if (!f.broll_dir.trim()) { this.ctl.error = 'Folder video B-Roll wajib dipilih.'; return; }
			} else {
				if (!f.file.trim()) { this.ctl.error = 'File video wajib diisi.'; return; }
				if (f.workflow === 'broll' && !f.broll_dir.trim()) { this.ctl.error = 'Folder video B-Roll wajib dipilih.'; return; }
			}
			const segments = [];
			if (f.workflow !== 'assembly') {
				for (const s of f.segments) {
					const st = this.ccParseTime(s.start), en = this.ccParseTime(s.end);
					if (st === null || en === null) { this.ctl.error = 'Format waktu tidak dikenali — pakai m:ss (mis. 6:02).'; return; }
					if (en <= st) { this.ctl.error = 'Selesai harus lebih besar dari mulai.'; return; }
					segments.push({ start: st, end: en });
				}
				if (!segments.length) { this.ctl.error = 'Minimal satu segmen.'; return; }
			} else {
				segments.push({ start: 0, end: 10 });
			}
			this.ctl.submitting = true;
			try {
				const d = await ccPost('/control/run', {
					workflow: f.workflow,
					template: f.src === 'template' ? f.template : '',
					template_label: f.src === 'template' ? f.template_label : '',
					aspect: f.aspect, srt: f.srt, cap_lang: f.cap_lang,
					local_stt: f.local_stt ? '1' : '',
					file: f.file, vo_file: f.vo_file,
					broll_dir: f.broll_dir, sfx_dir: f.sfx_dir,
					broll_vision: f.broll_vision ? '1' : '',
					broll_pacing: f.broll_pacing, broll_prompt: f.broll_prompt,
					broll_motion_in: f.broll_motion_in, broll_motion_out: f.broll_motion_out,
					edl_review: f.edl_review ? '1' : '',
					hook_ai: f.hook_ai ? '1' : '', extra_prompt: f.extra_prompt,
					mode: f.mode, moment_count: f.moment_count, moment_min: f.moment_min, moment_max: f.moment_max,
					silence_cut: f.silence_cut ? '1' : '', silence_db: f.silence_db, silence_min: f.silence_min, silence_pad: f.silence_pad,
					use_sfx: f.workflow === 'clip' && f.use_sfx ? '1' : '',
					// Selalu session baru — Create New = 1 project per submit.
					session_id: 0,
					segments: segments,
					start: segments[0].start, end: segments[0].end,
					name: f.name, action: f.action,
					output_name: f.output_name, dest_dir: f.dest_dir,
				});
				this.ctl.running = true;
				this.ctl.sessionId = d.session_id || 0;
				this.hasActive = true;
				// Panel Processes terbuka otomatis + pindah ke detail run —
				// checklist klip tampil di tengah, langkah detail di kanan.
				this.rightOpen = true;
				try { localStorage.setItem('cc_right', '1'); } catch (e) {}
				if (d.session_id) { this.nav('project/' + d.session_id); }
				this.loadSessions();
			} catch (e) { this.ctl.error = e.message; this.ctl.running = false; }
			this.ctl.submitting = false;
		},

		/* ---------------- library (B-Rolls / SFX) ---------------- */
		// dirs[kind] menampung folder per kind — override browse per-menu
		// tidak hilang saat pindah B-Rolls ↔ Sound Effects.
		lib: { kind: 'broll', dir: '', dirs: {}, items: [], loading: false, error: '' },

		async loadLibrary(kind) {
			this.lib.kind = kind;
			if (!(kind in this.lib.dirs)) {
				this.lib.dirs[kind] = ('sfx' === kind ? CC_DATA.sfxDir : CC_DATA.brollDir) || '';
			}
			this.lib.dir = this.lib.dirs[kind];
			this.lib.loading = true;
			this.lib.error = '';
			try {
				const d = await ccApi('GET', '/library?kind=' + kind + '&dir=' + encodeURIComponent(this.lib.dir));
				this.lib.dir = d.dir || this.lib.dir;
				this.lib.dirs[kind] = this.lib.dir;
				this.lib.items = (d.items || []).map((it) => Object.assign({ open: false }, it));
			} catch (e) { this.lib.items = []; this.lib.error = e.message; }
			this.lib.loading = false;
			this.$nextTick(() => this.icons());
		},

		fmtDur(sec) {
			sec = Math.max(0, +sec || 0);
			const m = Math.floor(sec / 60), s = Math.round(sec % 60);
			return m + ':' + (s < 10 ? '0' : '') + s;
		},

		/* ---------------- settings ---------------- */
		st: {
			tab: 'ai', saving: false, testing: '', loaded: false,
			notice: '', noticeOk: false,
			testResult: { openai: null, concat: null },
			keySet: false, tokenSet: false, automation: '', providers: {},
			templates: [], renaming: '', renameVal: '', confirm: '', confirmCb: null,
			f: { ai_provider: 'openai', ai_key: '', ai_model: '', ai_baseurl: '', openai_key: '', openai_model: '', concat_mode: 'auto', concat_addr: '', concat_token: '', workspace: '', copy_roots: '', broll_dir: '', sfx_dir: '' },
		},

		async loadSettings() {
			if (this.st.loaded) { return; }
			this.st.loaded = true;
			this.st.notice = '';
			try {
				const d = await ccApi('GET', '/settings');
				this.st.keySet = !!d.ai_key_set;
				this.st.providers = d.ai_providers || {};
				this.st.tokenSet = !!d.concat_token_set;
				this.st.automation = d.automation && d.automation.ok
					? 'automation.json terdeteksi — ' + d.automation.address
					: ((d.automation && d.automation.error) || 'automation.json tidak ditemukan.');
				this.st.f = {
					ai_provider: d.ai_provider || 'openai', ai_key: '', ai_model: d.ai_model || '', ai_baseurl: d.ai_baseurl || '',
					openai_key: '', openai_model: d.openai_model || '',
					concat_mode: d.concat_mode || 'auto', concat_addr: d.concat_addr || '', concat_token: '',
					workspace: d.workspace || '', copy_roots: d.copy_roots || '',
					broll_dir: d.broll_dir || '', sfx_dir: d.sfx_dir || '',
				};
			} catch (e) { this.st.loaded = false; this.st.notice = e.message; this.st.noticeOk = false; }
			this.$nextTick(() => this.icons());
		},

		async saveSettings() {
			if (this.st.saving) { return; }
			this.st.saving = true;
			this.st.notice = '';
			try {
				await ccPost('/settings', this.st.f);
				if (this.st.f.openai_key || this.st.f.ai_key) { this.st.keySet = true; this.st.f.openai_key = ''; this.st.f.ai_key = ''; }
				if (this.st.f.concat_token) { this.st.tokenSet = true; this.st.f.concat_token = ''; }
				CC_DATA.brollDir = this.st.f.broll_dir || '';
				CC_DATA.sfxDir = this.st.f.sfx_dir || '';
				if (!this.ctl.f.broll_dir) { this.ctl.f.broll_dir = CC_DATA.brollDir; }
				if (!this.ctl.f.sfx_dir) { this.ctl.f.sfx_dir = CC_DATA.sfxDir; }
				this.lib.dirs = {}; // folder default berubah → library re-fetch dari Settings baru
				this.st.notice = 'Pengaturan tersimpan.';
				this.st.noticeOk = true;
				this.loadStatus();
			} catch (e) { this.st.notice = e.message; this.st.noticeOk = false; }
			this.st.saving = false;
		},

		async loadTplList() {
			try {
				const d = await ccApi('GET', '/settings/templates');
				this.st.templates = d.templates || [];
				this.$nextTick(() => this.icons());
			} catch (e) { /* diam — list kosong */ }
		},
		async renameTemplate(t) {
			const name = (this.st.renameVal || '').trim();
			if (!name || name === t.name) { this.st.renaming = ''; return; }
			try {
				await ccPost('/settings/templates/rename', { path: t.path, name });
				this.st.renaming = '';
				await this.loadTplList();
				this.loadTemplates(); // daftar wizard ikut segar
			} catch (e) { this.st.notice = e.message; this.st.noticeOk = false; }
		},
		askConfirm(msg, cb) { this.st.confirm = msg; this.st.confirmCb = cb; this.$nextTick(() => this.icons()); },
		confirmYes() {
			const cb = this.st.confirmCb;
			this.st.confirm = ''; this.st.confirmCb = null;
			if (cb) { cb(); }
		},
		async deleteTemplate(t) {
			this.askConfirm('Hapus template "' + t.name + '"? Tidak bisa dikembalikan.', async () => {
				try {
					await ccPost('/settings/templates/delete', { path: t.path });
					await this.loadTplList();
					this.loadTemplates();
				} catch (e) { this.st.notice = e.message; this.st.noticeOk = false; }
			});
		},

		async testConn(which) {
			if (this.st.testing === which) { return; }
			this.st.testing = which;
			this.st.testResult[which] = null;
			try {
				const fd = new FormData();
				fd.append('which', which);
				const d = await ccApi('POST', '/settings/test', fd, 15000);
				this.st.testResult[which] = { ok: !!d.ok, message: d.message || '' };
			} catch (e) {
				this.st.testResult[which] = { ok: false, message: e.message };
			}
			this.st.testing = '';
			this.$nextTick(() => this.icons());
		},

		/* ---------------- messages ---------------- */

		adopt(m) {
			m._html = m.html;
			return m;
		},

		// Live placeholders ("…" thinking bubble) belong at the BOTTOM of the
		// thread, below their task cards — the row was inserted first, so its
		// id order would otherwise pin it to the top.
		isLive(m) {
			return m.role === 'assistant' && (m.status === 'queued' || m.status === 'running');
		},
		orderMsgs(list) {
			return list.filter((m) => !this.isLive(m)).concat(list.filter((m) => this.isLive(m)));
		},

		async pollMessages() {
			if (!this.activeId || !this.messages.length) { return; }
			// Last element is the relocated placeholder — its id is small.
			// Poll must use the MAX id or the server resends rows endlessly.
			const maxId = this.messages.reduce((a, m) => Math.max(a, m.id), 0);
			// Watch every non-terminal row so task cards / placeholders
			// keep refreshing without refetching the whole window.
			const watch = this.messages
				.filter((m) => m.status === 'queued' || m.status === 'running'
					|| (m.role === 'task' && m.status !== 'done' && m.status !== 'failed')
					|| (m.role === 'review' && m.status === 'pending'))
				.map((m) => m.id).join(',');
			try {
				const d = await ccApi('GET', '/sessions/' + this.activeId + '/messages?after=' + maxId + '&watch=' + watch);
				if (d.project !== undefined) { this.activeProject = d.project || ''; }
				this.hasActive = !!d.has_active;
				this.activeJobId = d.active_job_id || 0;
				this.jobDetail = d.job_detail || '';
				if (!this.hasActive && this.ctl.running) { this.ctl.running = false; }
				const map = {};
				this.messages.forEach((m) => { map[m.id] = m; });
				const startTyping = [];
				const applyUpdate = (m) => {
					const prev = map[m.id];
					if (!prev) { return; }
					const justFinished = m.role === 'assistant' && m.status === 'done'
						&& prev.status !== 'done' && !this._typing[m.id];
					prev.status = m.status;
					prev.meta = m.meta;
					prev.text = m.text;
					if (!this._typing[m.id]) { prev.html = m.html; prev._html = m.html; }
					if (justFinished) { startTyping.push(prev); }
				};
				(d.updates || []).forEach(applyUpdate);
				(d.items || []).forEach((m) => { if (!map[m.id]) { this.messages.push(this.adopt(m)); } });
				this.messages = this.orderMsgs(this.messages);
				startTyping.forEach((m) => this.typeIn(m));
				const nearBottom = () => {
					const t = this.threadEl();
					return !t || (t.scrollHeight - t.scrollTop - t.clientHeight) < 120;
				};
				this.$nextTick(() => {
					this.icons();
					if (nearBottom() || this._stickBottom) {
						this.scrollBottom();
						this._stickBottom = false;
					}
					this.updateJump();
				});
			} catch (e) { /* silent — retry next tick */ }
		},

		oldestId: 0, hasMore: false, _loadingOlder: false, _stickBottom: false, showJump: false,

		jumpBottom() {
			const t = this.threadEl();
			if (!t) { return; }
			t.scrollTo({ top: t.scrollHeight, behavior: 'smooth' });
		},
		scrollToLastUser() {
			const t = this.threadEl();
			if (!t) { return; }
			const rows = t.querySelectorAll('.cc-msg-user');
			if (rows.length) {
				rows[rows.length - 1].scrollIntoView({ block: 'start' });
			} else {
				this.scrollBottom();
			}
		},
		updateJump() {
			const t = this.threadEl();
			this.showJump = !!t && (t.scrollHeight - t.scrollTop - t.clientHeight) > 160;
		},

		async loadOlder() {
			if (this._loadingOlder || !this.hasMore || !this.oldestId) { return; }
			this._loadingOlder = true;
			const t = this.threadEl();
			const oldH = t ? t.scrollHeight : 0;
			const oldTop = t ? t.scrollTop : 0;
			try {
				const d = await ccApi('GET', '/sessions/' + this.activeId + '/messages?before=' + this.oldestId);
				const older = (d.items || []).map((m) => this.adopt(m));
				if (older.length) {
					this.messages = older.concat(this.messages);
					this.oldestId = d.oldest_id || this.oldestId;
					this.hasMore = !!d.has_more;
					// Keep the reader where they were while prepending.
					this.$nextTick(() => {
						const el = this.threadEl();
						if (el) { el.scrollTop = oldTop + (el.scrollHeight - oldH); }
						this.icons();
					});
				} else {
					this.hasMore = false;
				}
			} catch (e) { /* retry on next scroll */ }
			this._loadingOlder = false;
		},

		async typeIn(m) {
			this._typing[m.id] = true;
			const text = m.text || '';
			const step = Math.max(4, Math.round(text.length / 60)); // ~1s total
			for (let i = 0; i < text.length; i += step) {
				m.html = '<div class="cc-msg cc-msg-ai"><div class="cc-bubble cc-bubble-ai"><div class="cc-body"><p>'
					+ ccEscape(text.slice(0, i + step)).replace(/\n/g, '<br>')
					+ '<span class="cc-caret"></span></p></div></div></div>';
				await new Promise((r) => setTimeout(r, 20));
			}
			m.html = m._html;
			this.$nextTick(() => { this.icons(); this.scrollBottom(); });
		},

		async cancel() {
			if (!this.activeJobId) { return; }
			try {
				await ccPost('/jobs/' + this.activeJobId + '/cancel', {});
				this.hasActive = false;
				await this.pollMessages();
				this.loadSessions();
			} catch (e) { this.error = e.message; }
		},

		async cancelSessionJob(s) {
			if (!s.active_job_id) { return; }
			try {
				await ccPost('/jobs/' + s.active_job_id + '/cancel', {});
				if (s.id === this.activeId) {
					this.hasActive = false;
					await this.pollMessages();
				}
				this.loadSessions();
			} catch (e) { this.error = e.message; }
		},

		toggleDark() {
			this.dark = !this.dark;
			document.documentElement.classList.toggle('dark', this.dark);
			try { localStorage.setItem('cc_dark', this.dark ? '1' : '0'); } catch (e) {}
			this.$nextTick(() => this.icons());
		},

		toggleRight() {
			this.rightOpen = !this.rightOpen;
			try { localStorage.setItem('cc_right', this.rightOpen ? '1' : '0'); } catch (e) {}
			this.$nextTick(() => this.icons());
		},
	};
}
