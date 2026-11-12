<?php
/**
 * Path guards + pipeline helpers shared by the Control workflows
 * (inc/control.php, inc/assembly.php, inc/review.php, inc/rest.php).
 *
 * $ctx (array, by reference) travels through the pipeline:
 *   'job_id', 'cx' (CC_Concat), 'task_cb' (callable for
 *   progress reporting back to the job row + task message).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CC_Tools {

	/* -------------------------------------------------------------
	 * Path guards
	 * ----------------------------------------------------------- */

	private static function norm( $path ) {
		return wp_normalize_path( trim( (string) $path ) );
	}

	private static function under( $path, $root ) {
		$root = trailingslashit( self::norm( $root ) );
		$path = self::norm( $path ) . '/';
		// Windows paths are case-insensitive — compare that way there.
		if ( 'Windows' === PHP_OS_FAMILY ) {
			return 0 === stripos( $path, $root );
		}
		return '' !== trim( $root, '/' ) && 0 === strpos( $path, $root );
	}

	/** Folders the app may READ: home + copy roots + workspace. */
	public static function read_roots() {
		$roots   = cc_copy_roots();
		$roots[] = cc_workspace();
		$home    = (string) getenv( 'USERPROFILE' ) ?: (string) getenv( 'HOME' );
		if ( $home ) {
			$roots[] = wp_normalize_path( $home );
		}
		return array_filter( array_unique( $roots ) );
	}

	public static function read_allowed( $path ) {
		foreach ( self::read_roots() as $r ) {
			if ( self::under( $path, $r ) ) {
				return true;
			}
		}
		return false;
	}

	/** Folders copy_result may WRITE to: explicit whitelist only. */
	public static function write_allowed_dir( $dir ) {
		foreach ( cc_copy_roots() as $r ) {
			if ( self::under( $dir, $r ) ) {
				return true;
			}
		}
		return false;
	}

	private static function err( $e ) {
		return 'ERROR ' . $e->get_error_code() . ': ' . $e->get_error_message();
	}

	private static function cx( &$ctx ) {
		return $ctx['cx'];
	}

	/* -------------------------------------------------------------
	 * Pipeline helpers
	 * ----------------------------------------------------------- */

	/**
	 * replaceClipMedia expects a NewMedia descriptor (~14 fields). Build it
	 * from media.probe so callers only have to pass {project, clip, file}.
	 */
	public static function replace_clip_media( &$ctx, $project, $clip, $file ) {
		// media.import menyalin file ke assets/ proyek — wajib agar preview
		// Studio Inspirasi bisa membaca (path eksternal → preview kosong).
		$mi = self::cx( $ctx )->call( 'media.import', array( 'path' => $project, 'file' => $file ), 90 );
		if ( is_wp_error( $mi ) ) {
			return self::err( $mi );
		}
		$item = null;
		foreach ( array_reverse( (array) ( $mi['project']['media'] ?? $mi['media'] ?? array() ) ) as $m ) {
			if ( basename( (string) ( $m['path'] ?? '' ) ) === basename( (string) $file ) ) {
				$item = $m;
				break;
			}
		}
		if ( ! $item ) {
			// Fallback: item terakhir yang berjenis video.
			foreach ( array_reverse( (array) ( $mi['project']['media'] ?? $mi['media'] ?? array() ) ) as $m ) {
				if ( 'video' === ( $m['kind'] ?? '' ) ) {
					$item = $m;
					break;
				}
			}
		}
		if ( ! $item ) {
			return self::err( new WP_Error( 'cc_import', 'media.import tidak mengembalikan item media.' ) );
		}
		$p   = (string) ( $item['path'] ?? $file );
		$res = self::cx( $ctx )->call(
			'edit.apply',
			array(
				'path'    => $project,
				'command' => array( 'op' => 'replaceClipMedia', 'clipId' => $clip, 'item' => $item ),
			)
		);
		if ( is_wp_error( $res ) ) {
			return self::err( $res );
		}
		// Perbarui nama tampilan clip agar ikut nama media baru (cosmetic).
		self::cx( $ctx )->call(
			'edit.apply',
			array(
				'path'    => $project,
				'command' => array( 'op' => 'updateClip', 'clipId' => $clip, 'patch' => array( 'name' => basename( $p ) ) ),
			),
			15
		);
		return $res;
	}

	/**
	 * export.run → block on wait_export → report progress through
	 * $ctx['task_cb'] (the worker writes it to the job row + task card).
	 */
	public static function export_run( &$ctx, $project, $output_name ) {
		$name   = sanitize_file_name( $output_name ? $output_name : 'export.mp4' );
		if ( ! preg_match( '/\.(mp4|mov|mkv|webm)$/i', $name ) ) {
			$name .= '.mp4';
		}
		$output = cc_ws_exported() . $name;
		wp_mkdir_p( dirname( $output ) );

		$started = self::cx( $ctx )->call( 'export.run', array( 'path' => $project, 'output' => self::norm( $output ) ), 30 );
		if ( is_wp_error( $started ) ) {
			return self::err( $started );
		}
		$job = $started['job'] ?? '';
		if ( ! $job ) {
			return 'ERROR cc_export: respons export.run tidak membawa nama job.';
		}

		$cb = isset( $ctx['task_cb'] ) ? $ctx['task_cb'] : null;
		if ( $cb ) {
			call_user_func( $cb, 'export_start', array( 'job' => $job, 'output' => $output ) );
		}

		$done = self::cx( $ctx )->wait_export(
			$job,
			function ( $event, $params ) use ( $cb, $ctx ) {
				if ( 'export.progress' === $event && $cb ) {
					call_user_func( $cb, 'export_progress', $params );
				}
				// Abort the wait when the WP job got cancelled.
				if ( ! empty( $ctx['job_id'] ) ) {
					$j = cc_job_get( $ctx['job_id'] );
					if ( $j && 'cancelled' === $j->status ) {
						return false;
					}
				}
				return true;
			}
		);

		if ( is_wp_error( $done ) ) {
			return self::err( $done );
		}
		if ( $cb ) {
			call_user_func( $cb, 'export_done', $params = array( 'output' => $output ) );
		}
		return array( 'output' => self::norm( $output ), 'done' => $done );
	}

	/**
	 * Copy an exported file to a whitelisted destination dir + into
	 * wp-content/uploads/concat-chat/ so it can play inside the app.
	 */
	public static function copy_result( $source, $dest_dir ) {
		$source = self::norm( $source );
		if ( ! file_exists( $source ) ) {
			return 'ERROR cc_copy: file sumber tidak ditemukan: ' . $source;
		}
		$dest_dir = self::norm( $dest_dir );
		if ( ! self::write_allowed_dir( $dest_dir ) ) {
			return 'ERROR cc_copy: folder tujuan di luar daftar yang diizinkan: ' . $dest_dir
				. '. Diizinkan: ' . ( cc_copy_roots() ? implode( '; ', cc_copy_roots() ) : '(kosong — atur di Settings)' );
		}
		if ( ! wp_mkdir_p( $dest_dir ) ) {
			return 'ERROR cc_copy: gagal membuat folder tujuan.';
		}
		$base = basename( $source );
		$dest = trailingslashit( $dest_dir ) . $base;
		if ( ! copy( $source, $dest ) ) {
			return 'ERROR cc_copy: gagal menyalin ke ' . $dest;
		}

		// Public copy under uploads for in-app playback.
		$uploads = wp_upload_dir();
		$pub_dir = trailingslashit( $uploads['basedir'] ) . 'concat-chat/';
		wp_mkdir_p( $pub_dir );
		$pub = $pub_dir . $base;
		copy( $source, $pub );
		$url = trailingslashit( $uploads['baseurl'] ) . 'concat-chat/' . rawurlencode( $base );

		return array(
			'copied_to'   => self::norm( $dest ),
			'playable_url' => $url,
		);
	}
}
