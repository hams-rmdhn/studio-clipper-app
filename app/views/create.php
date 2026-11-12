<?php
/**
 * View: Create New — wizard produksi 4 langkah (Sumber → Bahan → Segmen →
 * Proyek & Aksi). Di-post ke POST /control/run; status run muncul di panel
 * Processes dan bisa dibuka lewat tautan "lihat detail".
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'create'" x-cloak class="cc-ctl">
	<p x-show="error" x-cloak x-text="error" class="cc-err"></p>
	<div class="cc-ctl-card">
		<!-- Indikator langkah -->
		<div class="cc-steps" role="list">
			<template x-for="(lbl, i) in ctlStepLabels()" :key="i">
				<div class="cc-step-item" :class="ctl.step === i ? 'cc-step-on' : (ctl.step > i ? 'cc-step-done' : '')">
					<button type="button" class="cc-step" @click="ctl.step = i">
						<span class="cc-step-num">
							<span x-show="ctl.step <= i" x-text="i + 1"></span>
							<svg x-show="ctl.step > i" x-cloak viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3.5 8.5 6.5 11.5 12.5 4.5"/></svg>
						</span>
						<span class="cc-step-lbl" x-text="lbl"></span>
					</button>
					<span x-show="i < ctlStepLabels().length - 1" class="cc-step-line" aria-hidden="true"></span>
				</div>
			</template>
		</div>

		<!-- LANGKAH 1: Sumber & Video / VO -->
		<div x-show="ctl.step === 0">
		<h4 class="cc-sec">Sumber & Video</h4>
		<label class="cc-field"><span>Jenis produksi</span>
			<select x-model="ctl.f.workflow" class="cc-input" @change="ctlSuggestName()">
				<option value="clip">Potong Video (Clipper — 1 video jadi klip pendek)</option>
				<option value="broll">Talking Head + Auto B-Roll & SFX (AI)</option>
				<option value="assembly">Rakit Penuh dari Voice Over + B-Roll & SFX (AI)</option>
			</select>
		</label>

		<div class="cc-field"><span>Sumber komposisi</span>
			<div class="cc-tabs">
				<button type="button" @click="ctl.f.src = 'template'" :class="ctl.f.src === 'template' && 'cc-tab-on'" class="cc-tab">Dari template</button>
				<button type="button" @click="ctl.f.src = 'baru'" :class="ctl.f.src === 'baru' && 'cc-tab-on'" class="cc-tab">Proyek baru</button>
			</div>
		</div>

		<label class="cc-field" x-show="ctl.f.src === 'template'"><span>Template</span>
			<select x-model="ctl.f.template" class="cc-input" @change="ctlTemplateChange()">
				<option value="">— pilih template —</option>
				<template x-for="t in ctl.templates" :key="t.path">
					<option :value="t.path" x-text="t.name.replace(/-/g,' ') + ' · ' + t.width + '×' + t.height"></option>
				</template>
			</select>
			<small class="cc-note" x-show="ctl.tplError" x-cloak x-text="ctl.tplError"></small>
			<small class="cc-note">Ukuran, frame, & gaya subtitle mengikuti template.</small>
		</label>

		<label class="cc-field" x-show="ctl.f.src === 'baru'"><span>Aspect ratio</span>
			<select x-model="ctl.f.aspect" class="cc-input">
				<option value="9:16">9:16 — vertikal (1080×1920)</option>
				<option value="16:9">16:9 — landscape (1920×1080)</option>
				<option value="1:1">1:1 — persegi (1080×1080)</option>
				<option value="4:5">4:5 — potrait feed (1080×1350)</option>
			</select>
		</label>

		<label class="cc-field" x-show="ctl.f.workflow !== 'assembly'">
			<span x-text="ctl.f.workflow === 'broll' ? 'Video utama (Talking Head)' : 'File video'"></span>
			<div class="cc-filerow">
				<input type="text" x-model="ctl.f.file" @input="ctlSuggestName()" class="cc-input" placeholder="/path/ke/video.mp4 atau URL YouTube">
				<button type="button" @click="ctlBrowseOpen('file', 'file')" class="cc-btn">Browse</button>
			</div>
			<small class="cc-note">Tempel link <code>youtube.com</code>/<code>youtu.be</code> atau pilih file video lokal.</small>
		</label>

		<label class="cc-field" x-show="ctl.f.workflow === 'assembly'" x-cloak>
			<span>File audio Voice Over (MP3/WAV)</span>
			<div class="cc-filerow">
				<input type="text" x-model="ctl.f.vo_file" @input="ctlSuggestName()" class="cc-input" placeholder="/path/ke/voiceover.mp3">
				<button type="button" @click="ctlBrowseOpen('vo_file', 'file')" class="cc-btn">Browse</button>
			</div>
			<small class="cc-note">Durasi akhir video mengikuti panjang Voice Over ini.</small>
		</label>

		</div>

		<!-- LANGKAH 2: Bahan B-Roll & Subtitle -->
		<div x-show="ctl.step === 1">
		<h4 class="cc-sec">Bahan & Subtitle</h4>
		<template x-if="ctl.f.workflow !== 'clip'">
			<div style="display:flex;flex-direction:column;gap:1rem">
				<label class="cc-field"><span>Folder koleksi video B-Roll</span>
					<div class="cc-filerow">
						<input type="text" x-model="ctl.f.broll_dir" class="cc-input" placeholder="/Users/.../Assets/broll">
						<button type="button" @click="ctlBrowseOpen('broll_dir', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note">Taruh semua klip video bahan (.mp4/.mov) di dalam satu folder.</small>
				</label>

				<div class="cc-field"><span>Pengenalan visual B-Roll</span>
					<label class="cc-note" style="display:flex;align-items:center;gap:.4rem;margin-top:0">
						<input type="checkbox" x-model="ctl.f.broll_vision"> Scan isi visual tiap video dengan AI Vision
					</label>
					<small class="cc-note">Jika tidak dicentang, AI mengenali klip dari nama file (instan & gratis). Hasil scan Vision di-cache di folder.</small>
				</div>

				<label class="cc-field"><span>Folder Sound Effects / SFX <em class="cc-tag">opsional</em></span>
					<div class="cc-filerow">
						<input type="text" x-model="ctl.f.sfx_dir" class="cc-input" placeholder="/Users/.../Assets/sfx">
						<button type="button" @click="ctlBrowseOpen('sfx_dir', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note">Koleksi audio transisi (.mp3/.wav) yang akan dipasang otomatis saat pergantian B-Roll.</small>
				</label>
			</div>
		</template>

		<div>
		<label class="cc-field"><span>Caption & transkrip bahasa</span>
			<select x-model="ctl.f.cap_lang" class="cc-input">
				<option value="id">Indonesia (auto-caption / Whisper)</option>
				<option value="en">English</option>
				<option value="auto">Deteksi otomatis</option>
				<option value="none">Tanpa subtitle</option>
			</select>
		</label>
		<label class="cc-field"><span>File .srt manual <em class="cc-tag">opsional</em></span>
			<div class="cc-filerow">
				<input type="text" x-model="ctl.f.srt" class="cc-input" placeholder="/path/ke/subtitle.srt — override transkrip otomatis">
				<button type="button" @click="ctlBrowseOpen('srt', 'file')" class="cc-btn">Browse</button>
			</div>
			<small class="cc-note">Kosongkan untuk memakai subtitle YouTube atau transkrip Whisper otomatis.</small>
		</label>
		<label class="cc-field" x-show="ctl.f.workflow === 'clip'" x-cloak><span>Transkripsi file lokal</span>
			<label class="cc-note" style="display:flex;align-items:center;gap:.4rem;margin-top:0">
				<input type="checkbox" x-model="ctl.f.local_stt"> Transkripsikan file video lokal dengan Whisper (AI)
			</label>
			<small class="cc-note">Diperlukan agar file lokal dapat subtitle, snap potongan ke tepi kalimat, rewrite hook, dan penempatan SFX AI — YouTube sudah otomatis via caption bawaan. Mode "momen terbaik (AI)" &amp; workflow B-Roll selalu menranskripsi; tidak berlaku bila bahasa "Tanpa subtitle".</small>
		</label>
		</div>

		</div>

		<!-- LANGKAH 3: Segmen, Potong & Arahan AI -->
		<div x-show="ctl.step === 2">
		<h4 class="cc-sec">Segmen & Arahan AI</h4>
		<template x-if="['clip','broll'].includes(ctl.f.workflow)">
			<div style="display:flex;flex-direction:column;gap:1rem">
				<div class="cc-field"><span>Segmen <em class="cc-tag">1 segmen = 1 proyek</em></span>
					<select x-model="ctl.f.mode" class="cc-input" style="margin-bottom:.55rem">
						<option value="manual">Manual — tentukan rentang waktu</option>
						<option value="moments">Otomatis — momen terbaik (AI)</option>
					</select>
					<div x-show="ctl.f.mode === 'moments'" class="cc-inline-row">
						<input type="number" x-model.number="ctl.f.moment_count" min="1" max="10" class="cc-input cc-input-num" title="Jumlah momen">
						<span class="cc-note">momen · durasi</span>
						<input type="number" x-model.number="ctl.f.moment_min" min="5" class="cc-input cc-input-num" title="Durasi minimum (detik)">
						<span class="cc-note">–</span>
						<input type="number" x-model.number="ctl.f.moment_max" min="10" class="cc-input cc-input-num" title="Durasi maksimum (detik)">
						<span class="cc-note">detik</span>
					</div>
					<template x-if="ctl.f.mode === 'manual'">
						<div>
							<template x-for="(s, i) in ctl.f.segments" :key="i">
								<div class="cc-segrow">
									<input type="text" x-model="s.start" class="cc-input cc-input-time" placeholder="2:30" inputmode="numeric">
									<span class="cc-note">s/d</span>
									<input type="text" x-model="s.end" class="cc-input cc-input-time" placeholder="3:32" inputmode="numeric">
									<button type="button" @click="ctl.f.segments.splice(i, 1)" x-show="ctl.f.segments.length > 1" class="cc-set" title="Hapus segmen" aria-label="Hapus segmen">
										<i data-lucide="x" class="w-4 h-4"></i>
									</button>
								</div>
							</template>
							<button type="button" @click="ctl.f.segments.push({start: '', end: ''})" class="cc-btn cc-btn-ghost cc-btn-sm">
								<i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah segmen
							</button>
						</div>
					</template>
					<small class="cc-note">Manual: format <code>m:ss</code>. Otomatis: AI pilih momen dari transkrip — judul dipakai sebagai nama proyek.</small>
				</div>

				<div class="cc-field"><span>Potong</span>
					<label class="cc-note" style="display:flex;align-items:center;gap:.4rem;margin-top:0">
						<input type="checkbox" x-model="ctl.f.silence_cut"> Potong jeda hening
					</label>
					<div x-show="ctl.f.silence_cut" class="cc-inline-row">
						<input type="number" x-model.number="ctl.f.silence_db" step="1" class="cc-input cc-input-num" title="Threshold dB">
						<span class="cc-note">dB ·</span>
						<input type="number" x-model.number="ctl.f.silence_min" step="0.1" min="0.2" class="cc-input cc-input-num" title="Min hening (detik)">
						<span class="cc-note">s hening · pad</span>
						<input type="number" x-model.number="ctl.f.silence_pad" step="0.05" class="cc-input cc-input-num" title="Padding (detik)">
						<span class="cc-note">s</span>
					</div>
					<small class="cc-note">Buang bagian tanpa suara di tiap segmen — konten lebih rapat.</small>
				</div>

				<div class="cc-field" x-show="ctl.f.workflow === 'clip'"><span>Sound Effect</span>
					<label class="cc-note" style="display:flex;align-items:center;gap:.4rem;margin-top:0">
						<input type="checkbox" x-model="ctl.f.use_sfx"> Gunakan Sound Effect
					</label>
					<div x-show="ctl.f.use_sfx" x-cloak class="cc-filerow" style="margin-top:.45rem">
						<input type="text" x-model="ctl.f.sfx_dir" class="cc-input" placeholder="/path/ke/Assets/sfx — kosong = default Settings">
						<button type="button" @click="ctlBrowseOpen('sfx_dir', 'dir')" class="cc-btn">Pilih Folder</button>
					</div>
					<small class="cc-note" x-show="ctl.f.use_sfx" x-cloak>SFX dipasang di awal klip & tiap sambungan hasil potong hening — AI memilih file yang paling cocok dari folder.</small>
				</div>
			</div>
		</template>

		<template x-if="['broll','assembly'].includes(ctl.f.workflow)">
			<div style="display:flex;flex-direction:column;gap:1rem">
				<label class="cc-field"><span>Ritme potongan B-Roll (Pacing)</span>
					<select x-model="ctl.f.broll_pacing" class="cc-input">
						<option value="calm">Santai (tiap 4–6.5 detik)</option>
						<option value="sentence">Mengikuti kalimat / topik (3–6 detik)</option>
						<option value="dynamic">Dinamis & cepat (tiap 2–4 detik)</option>
					</select>
				</label>
				<div class="cc-row2">
					<label class="cc-field"><span>Animasi masuk B-Roll</span>
						<select x-model="ctl.f.broll_motion_in" class="cc-input">
							<option value="slide">Slide — geser masuk (default)</option>
							<option value="fade">Fade — muncul memudar</option>
							<option value="pop">Pop — zoom cepat</option>
							<option value="none">Tanpa animasi</option>
						</select>
					</label>
					<label class="cc-field"><span>Animasi keluar B-Roll</span>
						<select x-model="ctl.f.broll_motion_out" class="cc-input">
							<option value="fade">Fade — keluar memudar (default)</option>
							<option value="slide">Slide — geser keluar</option>
							<option value="pop">Pop — zoom keluar</option>
							<option value="none">Tanpa animasi</option>
						</select>
					</label>
				</div>
				<small class="cc-note">Durasi animasi 0.3 detik. SFX & video utama tidak terpengaruh.</small>
				<label class="cc-field"><span>Instruksi untuk AI Director <em class="cc-tag">opsional</em></span>
					<textarea x-model="ctl.f.broll_prompt" rows="2" class="cc-input" placeholder="Misal: tampilkan B-roll alam saat membahas ketenangan, gunakan sfx whoosh di tiap transisi…"></textarea>
					<small class="cc-note">B-Roll otomatis di-fit memenuhi kanvas (fill) dan audionya di-mute agar suara utama jernih.</small>
				</label>
				<label class="cc-check"><input type="checkbox" x-model="ctl.f.edl_review">
					<span><strong>Review rencana B-Roll sebelum dipasang</strong><br>
					<small class="cc-note">Pipeline berjeda setelah AI menyusun sisipan — Anda bisa melihat preview tiap klip, mengedit, lalu melanjutkan rakitan.</small></span>
				</label>
			</div>
		</template>

		<template x-if="ctl.f.src === 'template'">
			<div class="cc-field"><span>Adaptasi template</span>
				<label class="cc-note" style="display:flex;align-items:center;gap:.4rem;margin-top:0">
					<input type="checkbox" x-model="ctl.f.hook_ai"> Tulis ulang teks hook dengan AI
				</label>
				<small class="cc-note">Overlay template otomatis menyesuaikan durasi segmen — CTA menempel di akhir, frame ikut memanjang/memendek. Hook ditulis ulang dari transkrip (elemen CTA tidak disentuh).</small>
			</div>
		</template>

		</div>

		<!-- LANGKAH 4: Proyek & Aksi -->
		<div x-show="ctl.step === ctlStepLabels().length - 1">
		<h4 class="cc-sec">Proyek & Aksi</h4>
		<label class="cc-field"><span>Nama proyek</span>
			<input type="text" x-model="ctl.f.name" class="cc-input" placeholder="reel-baru-01">
		</label>

		<div class="cc-field"><span>Aksi akhir</span>
			<label class="cc-radio"><input type="radio" value="handoff" x-model="ctl.f.action">
				Simpan & serah ke Studio Inspirasi — ekspor manual di aplikasi</label>
			<label class="cc-radio"><input type="radio" value="export" x-model="ctl.f.action">
				Langsung export via API</label>
		</div>

		<template x-if="ctl.f.action === 'export'">
			<div class="cc-row2">
				<label class="cc-field"><span>Nama output</span>
					<input type="text" x-model="ctl.f.output_name" class="cc-input" placeholder="reel.mp4">
				</label>
				<label class="cc-field"><span>Salin ke (opsional)</span>
					<select x-model="ctl.f.dest_dir" class="cc-input">
						<option value="">— tidak disalin —</option>
						<template x-for="r in ctl.copyRoots" :key="r">
							<option :value="r" x-text="r"></option>
						</template>
					</select>
					<small class="cc-note" x-show="!ctl.copyRoots.length" x-cloak>Kosong — atur folder tujuan di Settings.</small>
				</label>
			</div>
		</template>

		<label class="cc-field"><span>Prompt tambahan untuk AI <em class="cc-tag">opsional</em></span>
			<textarea x-model="ctl.f.extra_prompt" rows="3" class="cc-input" placeholder="Misal: suasana lebih energik, fokus ke momen emosional, gaya tegas dan lugas…"></textarea>
			<small class="cc-note">Diteruskan ke semua langkah AI di run ini — pemilihan momen, AI Director B-Roll, penulisan hook, dan pemilihan SFX.</small>
		</label>
		</div>

		<p x-show="ctl.error" x-cloak x-text="ctl.error" class="cc-err"></p>

		<div class="cc-ctl-act">
			<button type="button" @click="ctl.step--" x-show="ctl.step > 0" x-cloak class="cc-btn cc-btn-ghost">← Kembali</button>
			<button type="button" @click="ctl.step++" x-show="ctl.step < ctlStepLabels().length - 1" x-cloak class="cc-btn cc-btn-primary">Lanjut →</button>
			<button type="button" @click="submitControl()" :disabled="ctl.submitting || hasActive" x-show="ctl.step === ctlStepLabels().length - 1" x-cloak class="cc-btn cc-btn-primary">
				<i x-show="ctl.submitting" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
				Jalankan
			</button>
			<span x-show="ctl.running" x-cloak class="cc-run-status">
				<span class="cc-spin-dot"></span>
				<span x-text="jobDetail || 'Sedang berjalan…'"></span>
				<a href="#" @click.prevent="viewSession(ctl.sessionId)" x-show="ctl.sessionId" x-cloak>lihat detail →</a>
			</span>
		</div>
	</div>
</div>
