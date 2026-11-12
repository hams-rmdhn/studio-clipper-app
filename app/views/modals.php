<?php
/**
 * Modals — konfirmasi umum, rename/hapus project, file/folder browser.
 * (Modal Settings dihapus — sekarang jadi halaman sendiri.)
 */
defined( 'ABSPATH' ) || exit;
?>
<!-- ============ MODAL: KONFIRMASI UMUM ============ -->
<div x-show="st.confirm" x-cloak class="cc-ovl" style="z-index: 60" @click.self="st.confirm = ''" @keydown.escape.window="st.confirm = ''">
	<div class="cc-modal">
		<h3 class="cc-modal-title">Konfirmasi</h3>
		<p class="cc-note" x-text="st.confirm"></p>
		<div class="cc-modal-act">
			<span class="cc-flex1"></span>
			<button type="button" @click="st.confirm = ''" class="cc-btn cc-btn-ghost">Batal</button>
			<button type="button" @click="confirmYes()" class="cc-btn cc-btn-danger">
				<i data-lucide="check" class="w-3.5 h-3.5"></i> Ya, lanjutkan
			</button>
		</div>
	</div>
</div>

<!-- ============ MODAL: RENAME / HAPUS ============ -->
<div x-show="modal.open" x-cloak class="cc-ovl" @click.self="modal.open = false" @keydown.escape.window="modal.open = false">
	<div class="cc-modal">
		<h3 class="cc-modal-title" x-text="modal.confirm ? 'Hapus project?' : 'Rename project'"></h3>

		<template x-if="!modal.confirm">
			<div>
				<input type="text" x-model="modal.title" maxlength="200" class="cc-input" placeholder="Judul project" @keydown.enter="saveRename()">
				<div class="cc-modal-act">
					<button type="button" @click="askDelete()" :disabled="modal.busy" class="cc-btn cc-btn-danger">
						<i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
					</button>
					<span class="cc-flex1"></span>
					<button type="button" @click="modal.open = false" class="cc-btn cc-btn-ghost">Batal</button>
					<button type="button" @click="saveRename()" :disabled="modal.busy || !modal.title.trim()" class="cc-btn">
						<i x-show="modal.busy" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i> Simpan
					</button>
				</div>
			</div>
		</template>

		<template x-if="modal.confirm">
			<div>
				<p class="cc-note">Project <strong x-text="modal.title"></strong> beserta seluruh riwayatnya akan dihapus permanen.</p>
				<div class="cc-modal-act">
					<span class="cc-flex1"></span>
					<button type="button" @click="modal.confirm = false" :disabled="modal.busy" class="cc-btn cc-btn-ghost">Kembali</button>
					<button type="button" @click="confirmDelete()" :disabled="modal.busy" class="cc-btn cc-btn-danger">
						<i x-show="!modal.busy" data-lucide="trash-2" class="w-3.5 h-3.5"></i>
						<i x-show="modal.busy" x-cloak data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i> Ya, hapus
					</button>
				</div>
			</div>
		</template>
	</div>
</div>

<!-- ============ MODAL: DAFTAR KLIP PROJECT ============ -->
<div x-show="clipModal.open" x-cloak class="cc-ovl" @click.self="clipModal.open = false" @keydown.escape.window="clipModal.open = false">
	<div class="cc-modal">
		<div class="flex items-center justify-between mb-3">
			<h3 class="cc-modal-title">Klip — <span x-text="clipModal.title"></span></h3>
			<button type="button" @click="clipModal.open = false" class="cc-set" aria-label="Tutup"><i data-lucide="x" class="w-4 h-4"></i></button>
		</div>
		<div class="cc-clips">
			<template x-for="(c, ci) in clipModal.items" :key="ci">
				<div class="cc-clip">
					<span x-show="c.status === 'running' || c.status === 'queued'" class="cc-spin-dot"></span>
					<i x-show="c.status === 'done'" data-lucide="check-circle-2" class="w-4 h-4 cc-ok"></i>
					<i x-show="c.status === 'failed' || c.status === 'cancelled'" data-lucide="x-circle" class="w-4 h-4 cc-bad"></i>
					<span class="cc-flex1 truncate" x-text="c.title" :title="c.name || c.title"></span>
					<a x-show="c.video_url" x-cloak :href="c.video_url" class="cc-clip-dl" title="Unduh video"><i data-lucide="download" class="w-3.5 h-3.5"></i></a>
				</div>
			</template>
			<p x-show="!clipModal.items.length" x-cloak class="cc-note">Belum ada klip tercatat untuk project ini.</p>
		</div>
		<div class="cc-modal-act">
			<span class="cc-flex1"></span>
			<button type="button" @click="clipModal.open = false; viewSession(clipModal.sessionId)" class="cc-btn cc-btn-ghost">
				<i data-lucide="arrow-right" class="w-3.5 h-3.5"></i> Buka project
			</button>
		</div>
	</div>
</div>

<!-- ============ MODAL: FILE / FOLDER BROWSER ============ -->
<div x-show="ctl.browseOpen" x-cloak class="cc-ovl" style="z-index: 80" @click.self="ctl.browseOpen = false" @keydown.escape.window="ctl.browseOpen = false">
	<div class="cc-modal cc-modal-lg">
		<div class="flex items-center justify-between mb-3">
			<h3 class="cc-modal-title" x-text="ctl.browseMode === 'dir' ? 'Pilih folder' : 'Pilih file media'"></h3>
			<button type="button" @click="ctl.browseOpen = false" class="cc-set" aria-label="Tutup"><i data-lucide="x" class="w-4 h-4"></i></button>
		</div>
		<div class="cc-browse-path">
			<button type="button" @click="ctlBrowseTo(ctl.browse.parent)" :disabled="!ctl.browse.parent" class="cc-set" title="Naik" aria-label="Naik">
				<i data-lucide="arrow-up" class="w-4 h-4"></i>
			</button>
			<span x-text="ctl.browse.path" class="cc-browse-cur"></span>
			<button type="button" x-show="ctl.browseMode === 'dir'" x-cloak @click="ctlPickDir()" class="cc-btn cc-btn-primary cc-btn-sm">
				Gunakan Folder Ini
			</button>
		</div>
		<div class="cc-browse-list">
			<template x-for="d in ctl.browse.dirs" :key="d.path">
				<button type="button" @click="ctlBrowseTo(d.path)" class="cc-browse-item">
					<i data-lucide="folder" class="w-4 h-4"></i><span x-text="d.name"></span>
				</button>
			</template>
			<template x-for="f in ctl.browse.files" :key="f.path">
				<button type="button" @click="ctl.browseMode === 'dir' ? ctlPickDir() : ctlPick(f.path)" class="cc-browse-item cc-browse-file">
					<i data-lucide="file-video" class="w-4 h-4"></i><span x-text="f.name"></span>
					<span class="cc-browse-size" x-text="ctlSize(f.size)"></span>
				</button>
			</template>
			<p x-show="!ctl.browse.dirs.length && !ctl.browse.files.length && !ctl.browse.error" x-cloak class="cc-note">Tidak ada subfolder atau file media di folder ini.</p>
			<p x-show="ctl.browse.error" x-cloak x-text="ctl.browse.error" class="cc-err"></p>
		</div>
	</div>
</div>
