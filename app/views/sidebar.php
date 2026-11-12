<?php
/**
 * Sidebar kiri — brand, tombol Create New, navigasi utama, status koneksi.
 */
defined( 'ABSPATH' ) || exit;
?>
<aside class="cc-side" :class="sideOpen ? '' : 'cc-side-hidden'">
	<div class="cc-side-top">
		<div class="cc-brand">
			<i data-lucide="clapperboard" class="w-5 h-5 text-emerald-600"></i>
			<span>Studio Clipper</span>
		</div>
		<button type="button" @click="newRun()" class="cc-new">
			<i data-lucide="plus" class="w-4 h-4"></i> Create New
		</button>
	</div>

	<nav class="cc-nav">
		<template x-for="m in navItems" :key="m.view">
			<button type="button" @click="nav(m.view)" class="cc-nav-item"
				:class="navActive(m.view) ? 'cc-nav-on' : ''">
				<i :data-lucide="m.icon" class="w-4 h-4"></i>
				<span x-text="m.label"></span>
			</button>
		</template>
	</nav>

	<div class="cc-side-foot">
		<div class="cc-status" :title="statusHint">
			<span class="cc-dot" :class="statusOpenai ? 'cc-dot-ok' : 'cc-dot-off'"></span> OpenAI
			<span class="cc-dot ml-2" :class="statusConcat ? 'cc-dot-ok' : 'cc-dot-off'"></span> Studio Inspirasi
		</div>
		<button type="button" @click="nav('settings')" class="cc-set" title="Pengaturan" aria-label="Pengaturan">
			<i data-lucide="settings-2" class="w-4 h-4"></i>
		</button>
	</div>
</aside>
