<?php
/**
 * Panel kanan — proses yang sedang berjalan (job queued/running/waiting)
 * + badge saat ada review B-Roll yang menunggu keputusan.
 */
defined( 'ABSPATH' ) || exit;
?>
<aside class="cc-right" :class="rightOpen ? '' : 'cc-right-hidden'">
	<div class="cc-right-head">
		<i data-lucide="activity" class="w-4 h-4"></i>
		<span>Processes</span>
		<span class="cc-right-count" x-show="runningSessions.length" x-cloak x-text="runningSessions.length"></span>
	</div>
	<div class="cc-right-list">
		<template x-for="s in procItems" :key="s.id">
			<div class="cc-proc" :class="s.id === activeId ? 'cc-proc-on' : ''">
				<div class="cc-proc-head">
					<button type="button" @click="viewSession(s.id)" class="cc-proc-btn">
						<span class="cc-proc-title">
							<i x-show="s.pending_review" x-cloak data-lucide="scissors" class="w-3.5 h-3.5"></i>
							<span x-show="!s.pending_review && s.active" class="cc-spin-dot"></span>
							<i x-show="!s.active && !procFailed(s)" x-cloak data-lucide="check-circle-2" class="w-3.5 h-3.5 cc-ok"></i>
							<i x-show="!s.active && procFailed(s)" x-cloak data-lucide="x-circle" class="w-3.5 h-3.5 cc-bad"></i>
							<span class="truncate" x-text="s.title.replace(/-/g,' ')"></span>
						</span>
						<span class="cc-proc-detail" x-text="s.pending_review ? 'Review B-Roll menunggu keputusan — klik untuk membuka.' : (s.active ? (s.job_detail || 'Sedang berjalan…') : (procFailed(s) ? 'Gagal' : 'Selesai'))"></span>
						<span x-show="s.pending_review" x-cloak class="cc-proc-badge">Review menunggu</span>
					</button>
					<button type="button" x-show="s.active && s.active_job_id" x-cloak @click="cancelSessionJob(s)" class="cc-cancel" title="Batalkan job" aria-label="Batalkan job">
						<i data-lucide="square" class="w-3 h-3"></i>
					</button>
				</div>
				<!-- Langkah pipeline — task cards ala thread lama, penuh lebar. -->
				<div x-show="s.tasks && s.tasks.length && !s.pending_review" x-cloak class="cc-proc-steps">
					<template x-for="t in s.tasks" :key="t.id">
						<div class="cc-task cc-proc-task" :class="'cc-task-' + t.status">
							<span class="cc-task-dot"></span>
							<span class="cc-task-label" x-text="t.label"></span>
							<span x-show="t.progress" x-cloak class="cc-task-pct" x-text="t.progress + '%'"></span>
						</div>
					</template>
				</div>
			</div>
		</template>
		<p x-show="!procItems.length" x-cloak class="cc-proc-empty">Tidak ada proses berjalan.</p>
	</div>
</aside>
