<?php
/**
 * View: Projects — tabel semua run produksi (cc_sessions) dengan search
 * + pagination. Klik baris → detail proyek. Ikon pensil → rename/hapus.
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'projects'" x-cloak class="cc-view">
	<div class="cc-view-in">
		<div x-show="!sessions.length" x-cloak class="cc-hero">
			<i data-lucide="folder-kanban" class="w-10 h-10 mx-auto text-emerald-400"></i>
			<h2>Belum ada project</h2>
			<p>Mulai produksi baru lewat tombol <em>"Create New"</em> di sidebar.</p>
		</div>

		<template x-if="sessions.length">
			<div>
				<div class="cc-tbar">
					<input type="text" x-model="pg.projects.q" @input="pg.projects.page = 1"
						class="cc-input cc-search" placeholder="Cari project…">
					<span class="cc-note" x-text="tblCount(sessions, pg.projects.q) + ' project'"></span>
				</div>

				<table class="cc-table">
					<thead>
						<tr>
							<th>Project</th>
							<th>Status</th>
							<th>Videos</th>
							<th>Terakhir aktif</th>
							<th>Folder</th>
							<th class="cc-t-act"></th>
						</tr>
					</thead>
					<tbody>
						<template x-for="s in tblRows(sessions, pg.projects)" :key="s.id">
							<tr @click="openClips(s)" class="cc-tr-click" title="Lihat daftar klip">
								<td>
									<span class="cc-t-name">
										<span class="cc-card-icon"><i data-lucide="film" class="w-4 h-4"></i></span>
										<span class="truncate" x-text="s.title.replace(/-/g,' ')"></span>
									</span>
								</td>
								<td>
									<span x-show="s.active && !s.pending_review" x-cloak class="cc-badge cc-badge-run">
										<span class="cc-spin-dot"></span> Berjalan
									</span>
									<span x-show="s.pending_review" x-cloak class="cc-badge cc-badge-review">Review menunggu</span>
									<span x-show="!s.active && !s.pending_review" x-cloak class="cc-note">Selesai</span>
								</td>
								<td>
									<button type="button" x-show="s.clips && s.clips.length" x-cloak @click.stop="openClips(s)"
										class="cc-t-vids" title="Lihat daftar klip">
										<i data-lucide="video" class="w-3.5 h-3.5"></i>
										<span x-text="s.videos + ' video'"></span>
									</button>
									<span x-show="!s.clips || !s.clips.length" x-cloak class="cc-note">—</span>
								</td>
								<td><span class="cc-note" x-text="fmtDate(s.last_message_at)"></span></td>
								<td><span class="cc-card-path" :title="s.project" x-text="s.project ? (s.project.split('/').pop() || s.project) : '—'"></span></td>
								<td class="cc-t-actions">
									<button type="button" @click.stop="openRename(s)" class="cc-sess-act" title="Rename / hapus" aria-label="Rename / hapus">
										<i data-lucide="pencil" class="w-3.5 h-3.5"></i>
									</button>
								</td>
							</tr>
						</template>
						<tr x-show="!tblCount(sessions, pg.projects.q)" x-cloak>
							<td colspan="6" class="cc-t-empty">Tidak ada project yang cocok dengan pencarian.</td>
						</tr>
					</tbody>
				</table>

				<div class="cc-pager" x-show="tblPages(sessions, pg.projects.q) > 1" x-cloak>
					<button type="button" @click="pg.projects.page--" :disabled="pg.projects.page <= 1" class="cc-btn cc-btn-ghost cc-btn-sm">← Prev</button>
					<span class="cc-note" x-text="pg.projects.page + ' / ' + tblPages(sessions, pg.projects.q)"></span>
					<button type="button" @click="pg.projects.page++" :disabled="pg.projects.page >= tblPages(sessions, pg.projects.q)" class="cc-btn cc-btn-ghost cc-btn-sm">Next →</button>
				</div>
			</div>
		</template>
	</div>
</div>
