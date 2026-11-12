<?php
/**
 * router.php — front controller for `php -S`.
 *
 *   /                    → public/index.php (the whole app)
 *   /concat/v1/*         → REST dispatch (cc_rest_dispatch)
 *   /uploads/*           → exported-video copies (data dir)
 *   anything else        → false → built-in server serves static files
 *
 * Bound to 127.0.0.1 only — unreachable from the LAN.
 */

$uri = (string) parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH );
$uri = rawurldecode( $uri );
// Collapse repeated slashes — ccApi joins restUrl + '/path' → '//'. nginx
// normalizes this upstream in the WP original; php -S does not.
$uri = (string) preg_replace( '#/+#', '/', $uri );

// Static file that exists in docroot → serve as-is (assets, vendor).
$docroot = dirname( __DIR__ ) . '/public';
$real    = realpath( $docroot . $uri );
if ( $real && 0 === strpos( $real, realpath( $docroot ) ) && is_file( $real ) && '/index.php' !== $uri ) {
	return false;
}

require_once __DIR__ . '/bootstrap.php';

// Orphan check — exit (and take the worker down) if the Tauri parent died.
cc_sidecar_watchdog( 'server', 'worker' );

if ( '/' === $uri || '' === $uri ) {
	require $docroot . '/index.php';
	return true;
}

if ( 0 === strpos( $uri, '/concat/v1' ) ) {
	$sub = substr( $uri, strlen( '/concat/v1' ) );
	list( $status, $payload ) = cc_rest_dispatch( $_SERVER['REQUEST_METHOD'] ?? 'GET', 'concat/v1' . $sub );
	status_header( $status );
	header( 'Content-Type: application/json; charset=utf-8' );
	echo wp_json_encode( $payload );
	return true;
}

// /uploads/<file> — copies made by CC_Tools::copy_result for playback.
if ( 0 === strpos( $uri, '/uploads/' ) ) {
	$name = basename( $uri );
	$path = CC_DATA_DIR . '/uploads/' . $name;
	if ( ! is_file( $path ) ) {
		status_header( 404 );
		echo 'Not found';
		return true;
	}
	$mimes = array(
		'mp4' => 'video/mp4', 'm4v' => 'video/mp4', 'webm' => 'video/webm', 'mov' => 'video/quicktime',
		'mp3' => 'audio/mpeg', 'wav' => 'audio/wav', 'm4a' => 'audio/mp4', 'ogg' => 'audio/ogg',
		'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp',
	);
	$ext = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
	header( 'Content-Type: ' . ( $mimes[ $ext ] ?? 'application/octet-stream' ) );
	header( 'Content-Length: ' . filesize( $path ) );
	header( 'Cache-Control: private, max-age=3600' );
	header( 'Accept-Ranges: bytes' );
	readfile( $path );
	return true;
}

status_header( 404 );
echo 'Not found';
return true;
