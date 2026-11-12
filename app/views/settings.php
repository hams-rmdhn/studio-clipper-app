<?php
/**
 * View: Settings — halaman pengaturan (sebelumnya modal). Tab Template
 * sudah dipromosikan jadi menu sendiri; di sini tersisa Agen AI,
 * Studio Inspirasi, dan Folder.
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'settings'" x-cloak class="cc-view">
	<div class="cc-view-in cc-view-narrow">
		<div class="cc-ctl-card cc-set-card">
			<div class="cc-tabs">
				<template x-for="t in [['ai','Agen AI'],['concat','Studio Inspirasi'],['folder','Folder']]">
					<button type="button" @click="st.tab = t[0]" :class="st.tab === t[0] && 'cc-tab-on'" class="cc-tab" x-text="t[1]"></button>
				</template>
			</div>
			<p x-show="st.notice" x-cloak x-text="st.notice" class="cc-notice" :class="st.noticeOk ? 'cc-notice-ok' : 'cc-notice-err'"></p>

			<!-- TAB: OpenAI -->
			<div x-show="st.tab === 'ai'" class="cc-tabbody">
				<label class="cc-field"><span>AI Provider</span>
					<select x-model="st.f.ai_provider" class="cc-input">
						<template x-for="(p, k) in st.providers" :key="k">
							<option :value="k" x-text="p.label + (p.note ? ' — ' + p.note : '')"></option>
						</template>
					</select>
				</label>
				<label class="cc-field" x-show="st.providers[st.f.ai_provider] && st.providers[st.f.ai_provider].key"><span>API Key <em x-show="st.keySet" x-cloak class="cc-tag">tersimpan</em></span>
					<input type="password" x-model="st.f.ai_key" class="cc-input" :placeholder="st.keySet ? '•••••••• (isi untuk mengganti)' : 'sk-…'" autocomplete="new-password">
				</label>
				<label class="cc-field"><span>Model</span>
					<input type="text" x-model="st.f.ai_model" class="cc-input" :placeholder="st.providers[st.f.ai_provider] ? st.providers[st.f.ai_provider].model : 'gpt-4o-mini'">
				</label>
				<label class="cc-field" x-show="st.f.ai_provider === 'custom'"><span>Base URL</span>
					<input type="text" x-model="st.f.ai_baseurl" class="cc-input" placeholder="https://api.example.com/v1">
				</label>
				<div class="cc-test">
					<button type="button" @click="testConn('openai')" :disabled="st.testing === 'openai'" class="cc-btn">
						<i x-show="st.testing !== 'openai'" data-lucide="zap" class="w-3.5 h-3.5"></i>
						<i x-show="st.testing === 'openai'" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
						<span x-text="st.testing === 'openai' ? 'Mengetes…' : 'Test koneksi OpenAI'"></span>
					</button>
					<p x-show="st.testResult.openai" x-cloak class="cc-test-res"
						:class="st.testResult.openai && st.testResult.openai.ok ? 'cc-notice-ok' : 'cc-notice-err'"
						x-text="st.testResult.openai ? ((st.testResult.openai.ok ? '✓ ' : '✗ ') + st.testResult.openai.message) : ''"></p>
				</div>
			</div>

			<!-- TAB: Studio Inspirasi -->
			<div x-show="st.tab === 'concat'" class="cc-tabbody">
				<label class="cc-field"><span>Mode koneksi</span>
					<select x-model="st.f.concat_mode" class="cc-input">
						<option value="auto">Auto — baca automation.json</option>
						<option value="manual">Manual — address + token</option>
					</select>
				</label>
				<p class="cc-note" x-text="st.automation"></p>
				<template x-if="st.f.concat_mode === 'manual'">
					<div>
						<label class="cc-field"><span>Address</span>
							<input type="text" x-model="st.f.concat_addr" class="cc-input" placeholder="127.0.0.1:7420">
						</label>
						<label class="cc-field"><span>Token <em x-show="st.tokenSet" x-cloak class="cc-tag">tersimpan</em></span>
							<input type="password" x-model="st.f.concat_token" class="cc-input" :placeholder="st.tokenSet ? '•••••••• (isi untuk mengganti)' : 'min. 20 karakter'" autocomplete="new-password">
						</label>
					</div>
				</template>
				<div class="cc-test">
					<button type="button" @click="testConn('concat')" :disabled="st.testing === 'concat'" class="cc-btn">
						<i x-show="st.testing !== 'concat'" data-lucide="zap" class="w-3.5 h-3.5"></i>
						<i x-show="st.testing === 'concat'" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
						<span x-text="st.testing === 'concat' ? 'Mengetes…' : 'Test koneksi Studio Inspirasi'"></span>
					</button>
					<p x-show="st.testResult.concat" x-cloak class="cc-test-res"
						:class="st.testResult.concat && st.testResult.concat.ok ? 'cc-notice-ok' : 'cc-notice-err'"
						x-text="st.testResult.concat ? ((st.testResult.concat.ok ? '✓ ' : '✗ ') + st.testResult.concat.message) : ''"></p>
				</div>
			</div>

			<!-- TAB: Folder -->
			<div x-show="st.tab === 'folder'" class="cc-tabbody">
				<label class="cc-field"><span>Workspace (proyek & export sementara)</span>
					<div class="cc-filerow">
						<input type="text" x-model="st.f.workspace" class="cc-input" readonly @click="ctlBrowseOpen('st.workspace', 'dir')">
						<button type="button" @click="ctlBrowseOpen('st.workspace', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note">Harus di bawah home folder — batasan tulis Automation.</small>
				</label>
				<label class="cc-field"><span>Folder tujuan diizinkan (pisahkan dengan ;)</span>
					<textarea x-model="st.f.copy_roots" rows="3" class="cc-input" placeholder="D:\kegiatan;D:\kegiatan\dokumentasi"></textarea>
					<div class="cc-filerow" style="margin-top:.45rem">
						<span class="cc-note cc-flex1">Tambahkan satu folder lewat browser:</span>
						<button type="button" @click="ctlBrowseOpen('st.copy_roots', 'dir')" class="cc-btn cc-btn-sm">+ Tambah Folder</button>
					</div>
				</label>
				<label class="cc-field"><span>Folder B-Roll default</span>
					<div class="cc-filerow">
						<input type="text" x-model="st.f.broll_dir" class="cc-input" placeholder="— belum diatur —" readonly @click="ctlBrowseOpen('st.broll_dir', 'dir')">
						<button type="button" @click="ctlBrowseOpen('st.broll_dir', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note">Isian awal folder koleksi video B-Roll di form produksi & menu B-Rolls.</small>
				</label>
				<label class="cc-field"><span>Folder SFX default</span>
					<div class="cc-filerow">
						<input type="text" x-model="st.f.sfx_dir" class="cc-input" placeholder="— belum diatur —" readonly @click="ctlBrowseOpen('st.sfx_dir', 'dir')">
						<button type="button" @click="ctlBrowseOpen('st.sfx_dir', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note">Dipakai bila field folder SFX kosong, termasuk menu Sound Effects.</small>
				</label>
			</div>

			<div class="cc-modal-act">
				<span class="cc-flex1"></span>
				<button type="button" @click="saveSettings()" :disabled="st.saving" class="cc-btn">
					<i x-show="st.saving" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i> Simpan
				</button>
			</div>
		</div>
	</div>
</div>
