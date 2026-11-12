<?php
/**
 * View: Templates — tabel template Studio Inspirasi dengan search +
 * pagination. Aksi: rename inline, hapus, buat proyek baru dari template.
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'templates'" x-cloak class="cc-view">
	<div class="cc-view-in">
		<div x-show="!st.templates.length" x-cloak class="cc-hero">
			<i data-lucide="layout-template" class="w-10 h-10 mx-auto text-emerald-400"></i>
			<h2>Belum ada template</h2>
			<p>Template dibuat di aplikasi Studio Inspirasi — daftar di sini mengikuti isi folder templates milik app.</p>
		</div>

		<template x-if="st.templates.length">
			<div>
				<div class="cc-tbar">
					<input type="text" x-model="pg.templates.q" @input="pg.templates.page = 1"
						class="cc-input cc-search" placeholder="Cari template…">
					<span class="cc-note" x-text="tblCount(st.templates, pg.templates.q) + ' template'"></span>
				</div>

				<table class="cc-table">
					<thead>
						<tr>
							<th>Template</th>
							<th>Ukuran</th>
							<th class="cc-t-act">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<template x-for="t in tblRows(st.templates, pg.templates)" :key="t.path">
							<tr>
								<td>
									<span class="cc-t-name">
										<span class="cc-card-icon"><i data-lucide="layout-template" class="w-4 h-4"></i></span>
										<template x-if="st.renaming === t.path">
											<input type="text" x-model="st.renameVal" class="cc-input" @keydown.enter="renameTemplate(t)">
										</template>
										<template x-if="st.renaming !== t.path">
											<span class="truncate" x-text="t.name.replace(/-/g,' ')"></span>
										</template>
									</span>
								</td>
								<td><span class="cc-note" x-text="tplDims(t) || '—'"></span></td>
								<td class="cc-t-actions">
									<button type="button" class="cc-sess-act" :title="st.renaming === t.path ? 'Simpan nama' : 'Rename'"
										@click="st.renaming === t.path ? renameTemplate(t) : (st.renaming = t.path, st.renameVal = t.name)">
										<i :data-lucide="st.renaming === t.path ? 'check' : 'pencil'" class="w-3.5 h-3.5"></i>
									</button>
									<button type="button" class="cc-sess-act cc-sess-act-danger" title="Hapus template" @click="deleteTemplate(t)">
										<i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
									</button>
									<button type="button" @click="createFromTemplate(t)" class="cc-btn cc-btn-sm">
										<i data-lucide="plus" class="w-3.5 h-3.5"></i> Create New
									</button>
								</td>
							</tr>
						</template>
						<tr x-show="!tblCount(st.templates, pg.templates.q)" x-cloak>
							<td colspan="3" class="cc-t-empty">Tidak ada template yang cocok dengan pencarian.</td>
						</tr>
					</tbody>
				</table>

				<div class="cc-pager" x-show="tblPages(st.templates, pg.templates.q) > 1" x-cloak>
					<button type="button" @click="pg.templates.page--" :disabled="pg.templates.page <= 1" class="cc-btn cc-btn-ghost cc-btn-sm">← Prev</button>
					<span class="cc-note" x-text="pg.templates.page + ' / ' + tblPages(st.templates, pg.templates.q)"></span>
					<button type="button" @click="pg.templates.page++" :disabled="pg.templates.page >= tblPages(st.templates, pg.templates.q)" class="cc-btn cc-btn-ghost cc-btn-sm">Next →</button>
				</div>
			</div>
		</template>
	</div>
</div>
