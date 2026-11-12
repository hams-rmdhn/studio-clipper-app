<?php
/**
 * Job queue + worker — a 'control_run' job is one pipeline run
 * (clip / broll / assembly), executed by wp-cron (single event, +2s).
 * The pipeline stamps each step into the session thread as 'task' /
 * 'review' messages so the UI can show progress live.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cc_job_run', 'cc_job_run_worker' );

function cc_job_run_worker( $job_id ) {
	$job = cc_job_get( $job_id );
	if ( ! $job || ! in_array( $job->status, array( 'queued', 'running' ), true ) ) {
		return;
	}
	ignore_user_abort( true );
	set_time_limit( 0 );
	cc_job_update(
		$job_id,
		array( 'status' => 'running', 'started_at' => current_time( 'mysql' ), 'attempts' => (int) $job->attempts + 1 )
	);

	$finish = function ( $status, $body, $meta = null ) use ( $job_id, $job ) {
		$upd = array( 'body' => $body, 'status' => 'done' === $status ? 'done' : 'failed' );
		if ( is_array( $meta ) && $meta ) {
			$upd['meta'] = $meta;
		}
		cc_message_update( $job->message_id, $upd );
		cc_job_update( $job_id, array( 'status' => $status, 'finished_at' => current_time( 'mysql' ) ) );
	};

	try {
		if ( 'control_run' === $job->kind ) {
			$res = cc_control_run( $job );
			if ( is_wp_error( $res ) ) {
				$finish( 'failed', 'Maaf — ' . $res->get_error_message() );
			} elseif ( ! empty( $res['_waiting'] ) ) {
				// Gerbang review EDL — payload + kartu sudah disiapkan;
				// tahan job sampai user memutuskan lewat /control/edl-review.
				cc_job_update( $job_id, array( 'status' => 'waiting' ) );
			} else {
				$finish( 'done', (string) ( $res['body'] ?? '' ), $res['meta'] ?? null );
				// Bind proyek hasil rakitan ke sesi — workflow 'clip' sengaja
				// tidak bind (multi-proyek per run, bukan 1 proyek kerja).
				$pl = json_decode( (string) $job->payload, true );
				$wf = is_array( $pl ) ? (string) ( $pl['workflow'] ?? 'clip' ) : 'clip';
				if ( 'clip' !== $wf && ! empty( $res['meta']['project'] ) && function_exists( 'cc_session_project_set' ) ) {
					cc_session_project_set( $job->session_id, (string) $res['meta']['project'] );
				}
			}
			return;
		}
		$finish( 'failed', 'Jenis job tidak dikenal: ' . (string) $job->kind );
	} catch ( Throwable $e ) {
		$finish( 'failed', 'Maaf — terjadi kesalahan: ' . $e->getMessage() );
	}
}
