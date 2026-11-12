<?php
/**
 * App shell — seluruh UI Studio Clipper.
 * Port dari front-page.php: sidebar nav kiri · main view (hash-routed) ·
 * panel Processes kanan. CSS/JS dilayani statis; CC_DATA di-inline.
 */
defined( 'ABSPATH' ) || exit;

$css_v = CC_VERSION . '.' . (int) @filemtime( __DIR__ . '/assets/css/app.css' );
$js_v  = CC_VERSION . '.' . (int) @filemtime( __DIR__ . '/assets/js/chat.js' );

$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">'
	. '<rect width="24" height="24" rx="5" fill="#059669"/>'
	. '<g fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'
	. '<path d="M20.2 6 3 11l-.9-2.4c-.3-1.1.3-2.2 1.3-2.5l13.5-4c1.1-.3 2.2.3 2.5 1.3Z"/>'
	. '<path d="m6.2 5.3 3.1 3.9"/><path d="m12.4 3.4 3.1 4"/>'
	. '<path d="M3 11h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>'
	. '</g></svg>';
?><!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html( CC_APP_NAME ); ?></title>
	<?php // Dark preference applied pre-paint to avoid a light flash. ?>
	<script>try{if(localStorage.getItem('cc_dark')==='1'){document.documentElement.classList.add('dark')}}catch(e){}</script>
	<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<?php echo rawurlencode( $svg ); ?>">
	<link rel="stylesheet" href="/assets/css/app.css?v=<?php echo esc_attr( $css_v ); ?>">
</head>
<body>
<div class="cc-shell" x-data="ccChat()">

	<?php get_template_part( 'views/sidebar' ); ?>

	<!-- ============ MAIN ============ -->
	<main class="cc-main">
		<header class="cc-head">
			<button type="button" @click="sideOpen = !sideOpen" class="cc-burger" aria-label="Sidebar">
				<i data-lucide="panel-left" class="w-4 h-4"></i>
			</button>
			<button type="button" x-show="view === 'project'" x-cloak @click="nav('projects')" class="cc-burger" title="Kembali ke Projects" aria-label="Kembali">
				<i data-lucide="arrow-left" class="w-4 h-4"></i>
			</button>
			<h1 class="cc-title" x-text="viewTitle()"></h1>
			<span x-show="view === 'project' && hasActive" x-cloak class="cc-working">
				<span x-text="jobDetail || 'Sedang berjalan…'"></span>
				<button type="button" @click="cancel()" class="cc-cancel" title="Batalkan job" aria-label="Batalkan job">
					<i data-lucide="square" class="w-3 h-3"></i>
				</button>
			</span>
			<span x-show="view === 'project' && activeProject" x-cloak class="cc-chip" :title="activeProject">
				<i data-lucide="film" class="w-3.5 h-3.5"></i>
				<span x-text="(activeProject.split('/').pop() || activeProject).replace(/-/g,' ')"></span>
			</span>
			<div class="cc-head-act">
				<button type="button" @click="toggleDark()" class="cc-set" title="Mode gelap/terang" aria-label="Mode gelap">
					<i x-show="!dark" data-lucide="moon" class="w-4 h-4"></i>
					<i x-show="dark" x-cloak data-lucide="sun" class="w-4 h-4"></i>
				</button>
				<button type="button" @click="toggleRight()" class="cc-set" title="Panel proses" aria-label="Panel proses">
					<i data-lucide="panel-right" class="w-4 h-4"></i>
				</button>
			</div>
		</header>

		<?php
		get_template_part( 'views/create' );
		get_template_part( 'views/projects' );
		get_template_part( 'views/project-detail' );
		get_template_part( 'views/templates' );
		get_template_part( 'views/library' );
		get_template_part( 'views/settings' );
		?>
	</main>

	<?php
	get_template_part( 'views/processes' );
	get_template_part( 'views/modals' );
	?>
</div>

<script>
window.CC_DATA = <?php echo wp_json_encode(
	array(
		'restUrl'     => rest_url( 'concat/v1' ) . '/',
		'restNonce'   => '',
		'settingsUrl' => '/#settings',
		'userName'    => 'Admin',
		'workspace'   => cc_workspace(),
		'copyRoots'   => array_values( cc_copy_roots() ),
		'brollDir'    => (string) get_option( 'cc_broll_dir', '' ),
		'sfxDir'      => (string) get_option( 'cc_sfx_dir', '' ),
	)
); ?>;
</script>
<script src="/vendor/lucide.min.js"></script>
<script src="/assets/js/chat.js?v=<?php echo esc_attr( $js_v ); ?>"></script>
<script defer src="/vendor/alpine.min.js"></script>
</body>
</html>
