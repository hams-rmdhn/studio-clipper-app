<?php
/**
 * worker.php — job queue daemon. Replaces wp-cron: polls cc_jobs for
 * 'queued' rows and runs the full pipeline (cc_job_run_worker covers
 * waiting→queued resumes too). Tauri respawns this on crash; orphaned
 * 'running' jobs are failed by cc_jobs_reap after 20 min.
 */

require_once __DIR__ . '/bootstrap.php';

ignore_user_abort( true );
set_time_limit( 0 );

$log = CC_DATA_DIR . '/logs/worker.log';
$cc_log = function ( $msg ) use ( $log ) {
	@file_put_contents( $log, gmdate( 'Y-m-d H:i:s' ) . ' ' . $msg . "\n", FILE_APPEND );
};
$cc_log( 'worker start pid=' . getmypid() );

while ( true ) {
	cc_sidecar_watchdog( 'worker', 'server' ); // exit if Tauri parent died
	try {
		cc_jobs_reap();
		$job = $GLOBALS['wpdb']->get_row(
			"SELECT id FROM " . cc_table( 'jobs' ) . " WHERE status = 'queued' ORDER BY id LIMIT 1"
		);
		if ( $job ) {
			$cc_log( 'claim job #' . (int) $job->id );
			cc_job_run_worker( (int) $job->id );
			continue; // check for the next job immediately
		}
	} catch ( Throwable $e ) {
		$cc_log( 'worker error: ' . $e->getMessage() );
		usleep( 2000000 );
	}
	usleep( 500000 );
}
