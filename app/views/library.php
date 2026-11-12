<?php
/**
 * View: Library — tabel koleksi media dengan search + pagination.
 * Dipakai bersama untuk menu B-Rolls (kind=broll) dan Sound Effects
 * (kind=sfx). Data: GET /library?kind=…
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'brolls' || view === 'sfx'" x-cloak class="cc-view">
	<div class="cc-view-in">
		<div class="cc-tbar">
			<input type="text" x-model="pg.lib.q" @input="pg.lib.page = 1"
				class="cc-input cc-search" :placeholder="lib.kind === 'sfx' ? 'Cari sound effect…' : 'Cari B-Roll…'">
			<span class="cc-lib-dir" :title="lib.dir" x-text="lib.dir || 'Folder library belum diatur'"></span>
			<button type="button" @click="ctlBrowseOpen('lib.dir', 'dir')" class="cc-btn cc-btn-ghost cc-btn-sm">
				<i data-lucide="folder-open" class="w-3.5 h-3.5"></i> Ubah Folder
			</button>
			<button type="button" @click="loadLibrary(lib.kind)" class="cc-set" title="Muat ulang" aria-label="Muat ulang">
				<i data-lucide="refresh-ccw" class="w-4 h-4"></i>
			</button>
		</div>

		<p x-show="lib.error" x-cloak x-text="lib.error" class="cc-err"></p>
		<p x-show="lib.loading" x-cloak class="cc-note">Memuat library…</p>

		<template x-if="!lib.loading && !lib.dir">
			<div class="cc-hero">
				<i data-lucide="folder-open" class="w-10 h-10 mx-auto text-emerald-400"></i>
				<h2 x-text="lib.kind === 'sfx' ? 'Folder Sound Effects belum diatur' : 'Folder B-Rolls belum diatur'"></h2>
				<p>Atur folder default di <a href="#" @click.prevent="nav('settings')">Settings</a>, atau pilih folder lewat tombol "Ubah Folder".</p>
			</div>
		</template>

		<template x-if="!lib.loading && lib.dir && !lib.items.length && !lib.error">
			<div class="cc-hero">
				<i data-lucide="film" class="w-10 h-10 mx-auto text-emerald-400"></i>
				<h2>Folder kosong</h2>
				<p x-text="lib.kind === 'sfx' ? 'Tidak ada file audio (.mp3/.wav/…) di folder ini.' : 'Tidak ada file video (.mp4/.mov/…) di folder ini.'"></p>
			</div>
		</template>

		<!-- B-Roll: tabel dengan thumbnail + baris expand video -->
		<template x-if="lib.kind === 'broll' && lib.items.length">
			<div>
				<table class="cc-table">
					<thead>
						<tr>
							<th class="cc-t-thumb"></th>
							<th>Nama</th>
							<th>Durasi</th>
							<th>Ukuran</th>
							<th>Deskripsi</th>
						</tr>
					</thead>
					<tbody>
						<template x-for="it in tblRows(lib.items, pg.lib)" :key="it.id">
							<tr @click="it.open = !it.open" class="cc-tr-click" :class="it.open && 'cc-tr-open'">
								<td>
									<span class="cc-thumbcell">
										<img x-show="it.thumb" :src="it.thumb" alt="" loading="lazy">
										<i x-show="!it.thumb" data-lucide="film" class="w-4 h-4"></i>
									</span>
								</td>
								<td><span class="cc-t-name truncate" x-text="it.name" :title="it.name"></span></td>
								<td><span class="cc-note" x-text="fmtDur(it.duration)"></span></td>
								<td><span class="cc-note" x-text="it.width ? it.width + '×' + it.height : '—'"></span></td>
								<td><span class="cc-lib-desc" x-text="it.desc" :title="it.desc"></span></td>
							</tr>
							<tr x-show="it.open" x-cloak class="cc-tr-expand">
								<td colspan="5"><video controls preload="metadata" :src="it.video" class="cc-lib-vid"></video></td>
							</tr>
						</template>
						<tr x-show="!tblCount(lib.items, pg.lib.q)" x-cloak>
							<td colspan="5" class="cc-t-empty">Tidak ada B-Roll yang cocok dengan pencarian.</td>
						</tr>
					</tbody>
				</table>

				<div class="cc-pager" x-show="tblPages(lib.items, pg.lib.q) > 1" x-cloak>
					<button type="button" @click="pg.lib.page--" :disabled="pg.lib.page <= 1" class="cc-btn cc-btn-ghost cc-btn-sm">← Prev</button>
					<span class="cc-note" x-text="pg.lib.page + ' / ' + tblPages(lib.items, pg.lib.q)"></span>
					<button type="button" @click="pg.lib.page++" :disabled="pg.lib.page >= tblPages(lib.items, pg.lib.q)" class="cc-btn cc-btn-ghost cc-btn-sm">Next →</button>
				</div>
			</div>
		</template>

		<!-- SFX: tabel dengan audio player inline -->
		<template x-if="lib.kind === 'sfx' && lib.items.length">
			<div>
				<table class="cc-table">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Durasi</th>
							<th>Deskripsi</th>
							<th class="cc-t-act">Preview</th>
						</tr>
					</thead>
					<tbody>
						<template x-for="it in tblRows(lib.items, pg.lib)" :key="it.id">
							<tr>
								<td>
									<span class="cc-t-name">
										<span class="cc-card-icon"><i data-lucide="volume-2" class="w-4 h-4"></i></span>
										<span class="truncate" x-text="it.name" :title="it.name"></span>
									</span>
								</td>
								<td><span class="cc-note" x-text="fmtDur(it.duration)"></span></td>
								<td><span class="cc-lib-desc" x-text="it.desc" :title="it.desc"></span></td>
								<td class="cc-t-audio"><audio controls preload="none" :src="it.media" class="cc-lib-audio"></audio></td>
							</tr>
						</template>
						<tr x-show="!tblCount(lib.items, pg.lib.q)" x-cloak>
							<td colspan="4" class="cc-t-empty">Tidak ada sound effect yang cocok dengan pencarian.</td>
						</tr>
					</tbody>
				</table>

				<div class="cc-pager" x-show="tblPages(lib.items, pg.lib.q) > 1" x-cloak>
					<button type="button" @click="pg.lib.page--" :disabled="pg.lib.page <= 1" class="cc-btn cc-btn-ghost cc-btn-sm">← Prev</button>
					<span class="cc-note" x-text="pg.lib.page + ' / ' + tblPages(lib.items, pg.lib.q)"></span>
					<button type="button" @click="pg.lib.page++" :disabled="pg.lib.page >= tblPages(lib.items, pg.lib.q)" class="cc-btn cc-btn-ghost cc-btn-sm">Next →</button>
				</div>
			</div>
		</template>
	</div>
</div>
