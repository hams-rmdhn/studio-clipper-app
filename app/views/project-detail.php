<?php
/**
 * View: Project detail — BUKAN thread/chat. Tengah hanya menampilkan:
 * checklist progress per video (spinner → centang), kartu review EDL
 * yang menunggu keputusan, dan video yang sudah jadi. Detail langkah
 * pipeline (subtitle, cutting, dst.) hidup di panel Processes kanan.
 */
defined( 'ABSPATH' ) || exit;
?>
<div x-show="view === 'project'" x-cloak class="cc-detail">
	<div id="cc-thread" class="cc-thread" @scroll.passive="onScroll()">
		<div class="cc-thread-in">
			<!-- Checklist progress — satu baris per video. -->
			<div x-show="hasActive || activeClips.length" x-cloak class="cc-prog">
				<div class="cc-prog-row" :class="hasActive ? 'cc-prog-running' : 'cc-prog-done'">
					<span x-show="hasActive" class="cc-spin-dot"></span>
					<i x-show="!hasActive" data-lucide="check-circle-2" class="w-4 h-4"></i>
					<span x-text="hasActive ? 'Membuat video…' : 'Video selesai'"></span>
				</div>
				<template x-for="(c, ci) in activeClips" :key="ci">
					<div class="cc-prog-row" :class="'cc-prog-' + c.status">
						<span x-show="c.status === 'running' || c.status === 'queued'" class="cc-spin-dot"></span>
						<i x-show="c.status === 'done'" data-lucide="check-circle-2" class="w-4 h-4"></i>
						<i x-show="c.status === 'failed' || c.status === 'cancelled'" data-lucide="x-circle" class="w-4 h-4"></i>
						<span class="truncate" x-text="c.title"></span>
					</div>
				</template>
			</div>

			<!-- Kartu review EDL pending — keputusan user tetap di tengah. -->
			<template x-for="m in reviewMsgs" :key="m.id">
				<div x-html="m.html"></div>
			</template>

			<!-- Video yang sudah jadi — satu-satunya konten utama. -->
			<div x-show="doneClips.length" x-cloak class="cc-results">
				<template x-for="(c, ci) in doneClips" :key="ci">
					<div class="cc-result">
						<div class="cc-result-head">
							<i data-lucide="check-circle-2" class="w-4 h-4 cc-ok"></i>
							<span class="cc-flex1 truncate" x-text="c.title" :title="c.name || c.title"></span>
							<a x-show="c.video_url" x-cloak :href="c.video_url" download class="cc-clip-dl" title="Unduh video">
								<i data-lucide="download" class="w-3.5 h-3.5"></i>
							</a>
						</div>
						<template x-if="c.video_url">
							<video controls preload="metadata" :src="c.video_url" class="cc-video"></video>
						</template>
						<p x-show="!c.video_url && c.project" x-cloak class="cc-note cc-result-note">
							Proyek <strong x-text="c.name || c.title"></strong> siap — buka di Studio Inspirasi untuk ditinjau &amp; diekspor.
						</p>
					</div>
				</template>
			</div>

			<template x-if="!hasActive && !activeClips.length && !reviewMsgs.length && !loading">
				<div class="cc-hero">
					<i data-lucide="clapperboard" class="w-10 h-10 mx-auto text-emerald-400"></i>
					<h2>Belum ada video</h2>
					<p>Project ini belum menghasilkan klip yang tercatat.</p>
				</div>
			</template>
			<p x-show="error" x-cloak x-text="error" class="cc-err"></p>
		</div>
	</div>
</div>
