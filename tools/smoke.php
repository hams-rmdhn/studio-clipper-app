<?php
/**
 * smoke.php — CLI smoke test for the WP shim + SQLite port.
 * Run: php tools/smoke.php  (uses a throwaway CC_DATA_DIR in /tmp)
 */

$tmp = sys_get_temp_dir() . '/cc-smoke-' . getmypid();
putenv( 'CC_DATA_DIR=' . $tmp );
@mkdir( $tmp, 0777, true );

require __DIR__ . '/../app/server/bootstrap.php';

$fail = 0;
$t = function ( $name, $ok ) use ( &$fail ) {
	printf( "%-46s %s\n", $name, $ok ? 'OK' : 'FAIL' );
	if ( ! $ok ) {
		$fail++;
	}
};

global $wpdb;

/* tables installed */
$tables = $wpdb->get_col( "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name" );
$t( 'tables: sessions/messages/jobs/options', array_intersect( array( 'cc_sessions', 'cc_messages', 'cc_jobs', 'cc_options' ), $tables ) === array( 'cc_sessions', 'cc_messages', 'cc_jobs', 'cc_options' ) );

/* options */
update_option( 'cc_test_str', 'halo dunia' );
$t( 'get_option string', 'halo dunia' === get_option( 'cc_test_str' ) );
update_option( 'cc_test_arr', array( 'a' => 1, 'b' => 'x' ) );
$t( 'get_option serialized array', array( 'a' => 1, 'b' => 'x' ) === get_option( 'cc_test_arr' ) );
$t( 'get_option default', 'def' === get_option( 'cc_missing_opt', 'def' ) );

/* transients */
set_transient( 'cc_tr', 'v1', 60 );
$t( 'get_transient', 'v1' === get_transient( 'cc_tr' ) );
set_transient( 'cc_tr_exp', 'x', -5 );
$t( 'expired transient → false', false === get_transient( 'cc_tr_exp' ) );

/* prepare + insert/get_row */
$sid = cc_session_create( 1, 'sesi "tes" <b>html</b>' );
$t( 'cc_session_create id>0', $sid > 0 );
$row = cc_session_get( $sid );
$t( 'cc_session_get roundtrip', $row && sanitize_text_field( 'sesi "tes" <b>html</b>' ) === $row->title );

$mid = cc_message_add( $sid, 'user', 'pesan pertama', array( 'k' => 'v' ) );
$t( 'cc_message_add', $mid > 0 );
$msg = cc_message_get( $mid );
$t( 'message meta json', $msg && '{"k":"v"}' === $msg->meta );

list( $rows, $oldest, $more ) = cc_messages_page( $sid );
$t( 'cc_messages_page', 1 === count( $rows ) && ! $more );

/* prepare %d %s %f */
$q = $wpdb->prepare( 'SELECT %d, %s, %f', 7, "o'hara", 1.5 );
$t( 'prepare quoting', false !== strpos( $q, "7, 'o''hara', 1.5" ) );

/* update + delete */
cc_session_rename( $sid, 'judul baru' );
$t( 'update via cc_session_rename', 'judul baru' === cc_session_get( $sid )->title );

$jid = cc_job_create( $sid, $mid, array( 'x' => 1 ), 'control_run' );
$t( 'cc_job_create', $jid > 0 );
$t( 'cc_job_active_for_session', (int) cc_job_active_for_session( $sid )->id === $jid );
cc_job_cancel( $jid );
$t( 'cc_job_cancel', 'cancelled' === cc_job_get( $jid )->status );
$t( 'no active after cancel', ! cc_job_active_for_session( $sid ) );

/* WP_Error */
$e = new WP_Error( 'cc_x', 'gagal', array( 'status' => 418 ) );
$t( 'is_wp_error + getters', is_wp_error( $e ) && 'cc_x' === $e->get_error_code() && 418 === $e->as_rest_payload()['data']['status'] );

/* esc/sanitize */
$t( 'esc_html', '&lt;b&gt; &quot;x&quot;' === esc_html( '<b> "x"' ) );
$t( 'sanitize_key', 'abc_12' === sanitize_key( 'AbC_12$%^' ) );
$t( 'sanitize_file_name', 'abb.mp4' === sanitize_file_name( 'a<b>:b?.mp4' ) );
$t( 'wp_normalize_path', '/a/b/c' === wp_normalize_path( '\\a//b\\c' ) );

/* kses */
$dirty = '<p onclick="x()">hi <a href="javascript:bad()" onmouseover="y()">l</a> <script>alert(1)</script>ok</p>';
$clean = wp_kses_post( $dirty );
$t( 'wp_kses strips attrs+script', false === strpos( $clean, 'onclick' ) && false === strpos( $clean, 'script>' ) && false !== strpos( $clean, 'ok' ) );
$t( 'wpautop+make_clickable', false !== strpos( cc_render_body( 'lihat https://example.com/x ya' ), 'href="https://example.com/x"' ) );

/* REST registry + dispatch */
do_action( 'rest_api_init' ); // idempotent — registers again, fine
$_GET  = array();
$_POST = array();
list( $st, $pl ) = cc_rest_dispatch( 'GET', 'concat/v1/settings' );
$t( 'GET /concat/v1/settings 200', 200 === $st && is_array( $pl ) && isset( $pl['concat_mode'] ) );
list( $st, $pl ) = cc_rest_dispatch( 'GET', 'concat/v1/nope' );
$t( 'unknown route → 404', 404 === $st );
list( $st, $pl ) = cc_rest_dispatch( 'GET', 'concat/v1/sessions' );
$t( 'GET /concat/v1/sessions', 200 === $st && isset( $pl['items'] ) && 1 === count( $pl['items'] ) );

/* session delete path */
cc_session_delete( $sid );
$t( 'cc_session_delete cascade', null === cc_session_get( $sid ) && 0 === (int) $wpdb->get_var( "SELECT COUNT(*) FROM cc_messages WHERE session_id={$sid}" ) );

/* reaper sanity — fresh queued job not reaped */
$mid2 = cc_message_add( $sid, 'assistant', '', null, 'queued' );
$jid2 = cc_job_create( $sid, $mid2, array(), 'control_run' );
cc_jobs_reap();
$t( 'fresh job not reaped', 'queued' === cc_job_get( $jid2 )->status );

echo "\n" . ( $fail ? "{$fail} FAILURE(S)\n" : "ALL OK\n" );
exit( $fail ? 1 : 0 );
