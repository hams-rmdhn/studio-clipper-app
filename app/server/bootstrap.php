<?php
/**
 * bootstrap.php — shared init for router.php + worker.php.
 *
 * Defines ABSPATH/CC_DATA_DIR, loads the WP shim + all ported inc/
 * modules, opens the SQLite database, installs tables on first run,
 * then fires the 'init' and 'rest_api_init' hooks.
 */

if ( defined( 'CC_BOOTED' ) ) {
	return;
}
define( 'CC_BOOTED', true );

define( 'ABSPATH', dirname( __DIR__ ) . '/' ); // app/
define( 'CC_VERSION', '0.2.0' );
define( 'CC_APP_NAME', 'Studio Clipper' );

date_default_timezone_set( 'UTC' );

/* Data dir — overridable for dev; Tauri sets CC_DATA_DIR explicitly. */
$cc_data = (string) getenv( 'CC_DATA_DIR' );
if ( '' === $cc_data ) {
	$home    = (string) getenv( 'HOME' ) ?: sys_get_temp_dir();
	$cc_data = rtrim( $home, '/\\' ) . '/Library/Application Support/studio-clipper';
}
define( 'CC_DATA_DIR', $cc_data );

require_once __DIR__ . '/compat.php';

/* Per-install secret → WP salts/keys (settings.php uses AUTH_KEY etc). */
$cc_blob = cc_secret_blob();
if ( ! defined( 'AUTH_KEY' ) ) {
	define( 'AUTH_KEY', hash_hmac( 'sha256', 'auth', $cc_blob ) );
	define( 'SECURE_AUTH_KEY', hash_hmac( 'sha256', 'secure_auth', $cc_blob ) );
	define( 'LOGGED_IN_KEY', hash_hmac( 'sha256', 'logged_in', $cc_blob ) );
	define( 'NONCE_KEY', hash_hmac( 'sha256', 'nonce', $cc_blob ) );
}

/* Database. */
wp_mkdir_p( CC_DATA_DIR . '/logs' );
$GLOBALS['wpdb'] = new CC_DB( CC_DATA_DIR . '/app.db' );

/* Ported modules — same load order as theme/functions.php. */
$inc = ABSPATH . 'inc/';
require_once $inc . 'db.php';
require_once $inc . 'settings.php';
require_once $inc . 'concat.php';
require_once $inc . 'ai.php';
require_once $inc . 'openai.php';
require_once $inc . 'tools.php';
require_once $inc . 'jobs.php';
require_once $inc . 'control.php';
require_once $inc . 'assembly.php';
require_once $inc . 'review.php';
require_once $inc . 'render.php';
require_once $inc . 'rest.php';

/* 'init' → cc_install_tables (self-heal) + cc_jobs_reap. */
do_action( 'init' );
/* 'rest_api_init' → cc_register_routes fills cc_rest_routes. */
do_action( 'rest_api_init' );

cc_ws_ensure();

/**
 * Sidecar watchdog — writes this process' pid to CC_DATA_DIR/run/<self>.pid
 * and, when reparented to launchd (parent Tauri process died — covers
 * SIGTERM/SIGKILL where Rust's ExitRequested cleanup never runs), kills the
 * sibling sidecar then exits. Called once by each entry point; the worker
 * also re-checks ppid every loop.
 *
 * @param string $self    'server' | 'worker'
 * @param string $sibling the other sidecar's pid-file name
 */
function cc_sidecar_watchdog( $self, $sibling ) {
	static $wrote = false;
	$run = CC_DATA_DIR . '/run';
	if ( ! $wrote ) {
		wp_mkdir_p( $run );
		@file_put_contents( $run . '/' . $self . '.pid', (string) getmypid() );
		$wrote = true;
	}
	$ppid = function_exists( 'posix_getppid' ) ? posix_getppid() : -1;
	if ( -1 === $ppid || 1 !== $ppid ) {
		return;
	}
	$pid = (int) @file_get_contents( $run . '/' . $sibling . '.pid' );
	if ( $pid > 0 && function_exists( 'posix_kill' ) ) {
		@posix_kill( $pid, 15 ); // SIGTERM sibling
	}
	@unlink( $run . '/' . $self . '.pid' );
	@unlink( $run . '/' . $sibling . '.pid' );
	// exit() only ends the current request under `php -S` — signal self.
	if ( function_exists( 'posix_kill' ) ) {
		@posix_kill( getmypid(), 15 );
	}
	exit( 0 );
}
