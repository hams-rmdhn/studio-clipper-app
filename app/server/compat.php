<?php
/**
 * compat.php — WordPress API shim for Studio Clipper.
 *
 * Replaces the WP runtime so the ported inc/*.php layer keeps working:
 * $wpdb over PDO-SQLite, options/transients in cc_options, a minimal
 * REST registry + request object, hook registry, sanitize/esc helpers,
 * and single-admin auth stubs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =====================================================================
 * Constants WP defines that inc/ relies on.
 * =================================================================== */

if ( ! defined( 'MINUTE_IN_SECONDS' ) ) {
	define( 'MINUTE_IN_SECONDS', 60 );
}
if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
	define( 'HOUR_IN_SECONDS', 3600 );
}
if ( ! defined( 'DAY_IN_SECONDS' ) ) {
	define( 'DAY_IN_SECONDS', 86400 );
}

/* =====================================================================
 * WP_Error
 * =================================================================== */

class WP_Error {
	private $code;
	private $message;
	private $data;

	public function __construct( $code = '', $message = '', $data = '' ) {
		$this->code    = $code;
		$this->message = $message;
		$this->data    = $data;
	}

	public function get_error_code() {
		return $this->code;
	}

	public function get_error_message() {
		return $this->message;
	}

	public function get_error_data() {
		return $this->data;
	}

	/** WP-REST shape: {code, message, data:{status}} */
	public function as_rest_payload() {
		$status = 500;
		if ( is_array( $this->data ) && isset( $this->data['status'] ) ) {
			$status = (int) $this->data['status'];
		}
		return array(
			'code'    => $this->code,
			'message' => $this->message,
			'data'    => array( 'status' => $status ),
		);
	}
}

function is_wp_error( $thing ) {
	return $thing instanceof WP_Error;
}

function wp_error( $code, $message = '', $data = '' ) {
	return new WP_Error( $code, $message, $data );
}

/* =====================================================================
 * $wpdb — PDO-SQLite facade (subset shaped on actual call sites)
 * =================================================================== */

class CC_DB {
	public $prefix     = '';
	public $insert_id  = 0;
	public $last_error = '';
	public $num_rows   = 0;
	/** @var PDO */
	private $pdo;

	public function __construct( $db_path ) {
		$this->pdo = new PDO( 'sqlite:' . $db_path, null, null, array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		) );
		$this->pdo->exec( 'PRAGMA journal_mode=WAL' );
		$this->pdo->exec( 'PRAGMA busy_timeout=8000' );
		$this->pdo->exec( 'PRAGMA foreign_keys=ON' );
	}

	public function pdo() {
		return $this->pdo;
	}

	/** WP-style placeholders: %d %f %s %% — args may be variadic or one array. */
	public function prepare( $query, $args = null ) {
		if ( null === $args ) {
			return $query;
		}
		if ( func_num_args() === 2 && is_array( $args ) ) {
			$args = $args;
		} else {
			$args = func_get_args();
			array_shift( $args );
		}
		$i   = 0;
		$out = '';
		$len = strlen( $query );
		for ( $p = 0; $p < $len; $p++ ) {
			$c = $query[ $p ];
			if ( '%' !== $c ) {
				$out .= $c;
				continue;
			}
			$t = $query[ $p + 1 ] ?? '';
			if ( '%' === $t ) {
				$out .= '%';
				$p++;
				continue;
			}
			$v = $i < count( $args ) ? $args[ $i++ ] : null;
			switch ( $t ) {
				case 'd':
					$out .= (string) (int) $v;
					break;
				case 'f':
					$out .= (string) (float) $v;
					break;
				case 's':
				default:
					$out .= null === $v ? "''" : $this->pdo->quote( (string) $v );
					break;
			}
			$p++;
		}
		return $out;
	}

	public function query( $sql ) {
		try {
			$this->last_error = '';
			$stmt             = $this->pdo->query( $sql );
			$this->num_rows   = $stmt->rowCount();
			return $stmt;
		} catch ( Throwable $e ) {
			$this->last_error = $e->getMessage();
			return false;
		}
	}

	public function get_row( $sql = null, $output = null, $y = 0 ) {
		if ( null === $sql ) {
			return null;
		}
		$stmt = $this->query( $sql );
		if ( ! $stmt ) {
			return null;
		}
		$rows = $stmt->fetchAll( PDO::FETCH_OBJ );
		return isset( $rows[ $y ] ) ? $rows[ $y ] : null;
	}

	public function get_results( $sql = null, $output = null ) {
		if ( null === $sql ) {
			return array();
		}
		$stmt = $this->query( $sql );
		return $stmt ? $stmt->fetchAll( PDO::FETCH_OBJ ) : array();
	}

	public function get_var( $sql = null, $x = 0, $y = 0 ) {
		$row = $this->get_row( $sql, null, $y );
		if ( ! $row ) {
			return null;
		}
		$vals = array_values( (array) $row );
		return $vals[ $x ] ?? null;
	}

	public function get_col( $sql = null, $x = 0 ) {
		$out = array();
		foreach ( (array) $this->get_results( $sql ) as $row ) {
			$vals   = array_values( (array) $row );
			$out[]  = $vals[ $x ] ?? null;
		}
		return $out;
	}

	/* -- write helpers ------------------------------------------------ */

	private function build_set( $data, $formats ) {
		$cols = array();
		$vals = array();
		$i    = 0;
		foreach ( (array) $data as $k => $v ) {
			$cols[] = '`' . str_replace( '`', '', $k ) . '`';
			$vals[] = $this->cast( $v, $formats[ $i ] ?? '%s' );
			$i++;
		}
		return array( $cols, $vals );
	}

	private function cast( $v, $fmt ) {
		if ( null === $v ) {
			return null;
		}
		return '%d' === $fmt ? (int) $v : ( '%f' === $fmt ? (float) $v : $v );
	}

	private function where_clause( $where, $formats ) {
		$conds = array();
		$vals  = array();
		$i     = 0;
		foreach ( (array) $where as $k => $v ) {
			$conds[] = '`' . str_replace( '`', '', $k ) . '` = ?';
			$vals[]  = $this->cast( $v, $formats[ $i ] ?? '%s' );
			$i++;
		}
		return array( implode( ' AND ', $conds ), $vals );
	}

	public function insert( $table, $data, $format = null ) {
		list( $cols, $vals ) = $this->build_set( $data, (array) $format );
		$sql = 'INSERT INTO ' . $table . ' (' . implode( ',', $cols ) . ') VALUES ('
			. rtrim( str_repeat( '?,', count( $cols ) ), ',' ) . ')';
		try {
			$this->pdo->prepare( $sql )->execute( $vals );
			$this->insert_id  = (int) $this->pdo->lastInsertId();
			$this->last_error = '';
			return 1;
		} catch ( Throwable $e ) {
			$this->last_error = $e->getMessage();
			return false;
		}
	}

	public function replace( $table, $data, $format = null ) {
		list( $cols, $vals ) = $this->build_set( $data, (array) $format );
		$sql = 'INSERT OR REPLACE INTO ' . $table . ' (' . implode( ',', $cols ) . ') VALUES ('
			. rtrim( str_repeat( '?,', count( $cols ) ), ',' ) . ')';
		try {
			$this->pdo->prepare( $sql )->execute( $vals );
			$this->insert_id  = (int) $this->pdo->lastInsertId();
			$this->last_error = '';
			return 1;
		} catch ( Throwable $e ) {
			$this->last_error = $e->getMessage();
			return false;
		}
	}

	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		list( $cols, $vals )     = $this->build_set( $data, (array) $format );
		list( $wcond, $wvals )   = $this->where_clause( $where, (array) $where_format );
		$set  = implode( '=?,', $cols ) . '=?';
		$sql  = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $wcond;
		try {
			$stmt = $this->pdo->prepare( $sql );
			$stmt->execute( array_merge( $vals, $wvals ) );
			$this->last_error = '';
			return $stmt->rowCount();
		} catch ( Throwable $e ) {
			$this->last_error = $e->getMessage();
			return false;
		}
	}

	public function delete( $table, $where, $where_format = null ) {
		list( $wcond, $wvals ) = $this->where_clause( $where, (array) $where_format );
		try {
			$stmt = $this->pdo->prepare( 'DELETE FROM ' . $table . ' WHERE ' . $wcond );
			$stmt->execute( $wvals );
			$this->last_error = '';
			return $stmt->rowCount();
		} catch ( Throwable $e ) {
			$this->last_error = $e->getMessage();
			return false;
		}
	}

	public function get_charset_collate() {
		return '';
	}
}

$GLOBALS['wpdb'] = null; // set by bootstrap after DB open

/* =====================================================================
 * Options + transients — cc_options(name PK, value, expires)
 * =================================================================== */

function cc_options_table() {
	return 'cc_options';
}

function maybe_serialize( $data ) {
	if ( is_array( $data ) || is_object( $data ) ) {
		return serialize( $data );
	}
	return $data;
}

function maybe_unserialize( $data ) {
	if ( is_string( $data ) && strlen( $data ) > 1
		&& ( 'a:' === substr( $data, 0, 2 ) || 'O:' === substr( $data, 0, 2 ) ) ) {
		$out = @unserialize( $data );
		if ( false !== $out || 'b:0;' === $data ) {
			return $out;
		}
	}
	return $data;
}

function get_option( $name, $default = false ) {
	global $wpdb;
	$row = $wpdb->get_row(
		$wpdb->prepare( 'SELECT value, expires FROM ' . cc_options_table() . ' WHERE name = %s', (string) $name )
	);
	if ( ! $row ) {
		return $default;
	}
	if ( null !== $row->expires && (int) $row->expires > 0 && (int) $row->expires < time() ) {
		delete_option( $name );
		return $default;
	}
	return maybe_unserialize( $row->value );
}

function update_option( $name, $value, $autoload = null ) {
	global $wpdb;
	// Transient-style names are managed through set_transient only; the
	// expires column stays untouched by plain updates.
	$exists = $wpdb->get_var(
		$wpdb->prepare( 'SELECT COUNT(*) FROM ' . cc_options_table() . ' WHERE name = %s', (string) $name )
	);
	if ( $exists ) {
		return false !== $wpdb->update(
			cc_options_table(),
			array( 'value' => maybe_serialize( $value ) ),
			array( 'name' => (string) $name ),
			array( '%s' ),
			array( '%s' )
		);
	}
	return false !== $wpdb->insert(
		cc_options_table(),
		array( 'name' => (string) $name, 'value' => maybe_serialize( $value ), 'expires' => null ),
		array( '%s', '%s', '%d' )
	);
}

function add_option( $name, $value, $deprecated = '', $autoload = null ) {
	if ( false !== get_option( $name, false ) ) {
		return false;
	}
	return update_option( $name, $value );
}

function delete_option( $name ) {
	global $wpdb;
	return (bool) $wpdb->delete( cc_options_table(), array( 'name' => (string) $name ) );
}

function set_transient( $name, $value, $ttl = 0 ) {
	global $wpdb;
	$wpdb->delete( cc_options_table(), array( 'name' => '_transient_' . (string) $name ) );
	return false !== $wpdb->insert(
		cc_options_table(),
		array(
			'name'    => '_transient_' . (string) $name,
			'value'   => maybe_serialize( $value ),
			// WP semantics: 0 = never expires, negative/past = already expired.
			'expires' => 0 === (int) $ttl ? null : time() + (int) $ttl,
		),
		array( '%s', '%s', '%d' )
	);
}

function get_transient( $name ) {
	return get_option( '_transient_' . (string) $name, false );
}

function delete_transient( $name ) {
	return delete_option( '_transient_' . (string) $name );
}

/* =====================================================================
 * Hooks — registry minimal; schedule/cron are no-ops (worker daemon polls)
 * =================================================================== */

function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
	$GLOBALS['cc_hooks'][ $hook ][ $priority ][] = array( $callback, (int) $accepted_args );
	return true;
}

function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
	return add_action( $hook, $callback, $priority, $accepted_args );
}

function do_action( $hook, ...$args ) {
	if ( empty( $GLOBALS['cc_hooks'][ $hook ] ) ) {
		return;
	}
	$prios = $GLOBALS['cc_hooks'][ $hook ];
	ksort( $prios );
	foreach ( $prios as $cbs ) {
		foreach ( $cbs as $cb ) {
			call_user_func_array( $cb[0], array_slice( $args, 0, max( 1, $cb[1] ) ) );
		}
	}
}

function apply_filters( $hook, $value, ...$args ) {
	if ( empty( $GLOBALS['cc_hooks'][ $hook ] ) ) {
		return $value;
	}
	$prios = $GLOBALS['cc_hooks'][ $hook ];
	ksort( $prios );
	foreach ( $prios as $cbs ) {
		foreach ( $cbs as $cb ) {
			$value = call_user_func_array( $cb[0], array_merge( array( $value ), array_slice( $args, 0, max( 0, $cb[1] - 1 ) ) ) );
		}
	}
	return $value;
}

function __return_true() {
	return true;
}

function __return_false() {
	return false;
}

/** Cron = no-op. The worker daemon polls cc_jobs for 'queued' rows. */
function wp_schedule_single_event( $timestamp, $hook, $args = array() ) {
	return true;
}

function spawn_cron( $gmt_time = 0 ) {
	return true;
}

/* =====================================================================
 * REST — register_rest_route registry + WP_REST_Request + dispatch
 * =================================================================== */

class WP_REST_Request implements ArrayAccess {
	private $params = array(
		'URL'  => array(),
		'GET'  => array(),
		'POST' => array(),
		'JSON' => array(),
	);
	private $method = 'GET';
	private $route  = '';

	public function __construct( $method = 'GET', $route = '' ) {
		$this->method = strtoupper( (string) $method );
		$this->route  = (string) $route;
	}

	public function set_url_params( $params ) {
		$this->params['URL'] = (array) $params;
	}

	public function set_query_params( $params ) {
		$this->params['GET'] = (array) $params;
	}

	public function set_body_params( $params ) {
		$this->params['POST'] = (array) $params;
	}

	public function set_json_params( $params ) {
		$this->params['JSON'] = (array) $params;
	}

	public function get_method() {
		return $this->method;
	}

	public function get_route() {
		return $this->route;
	}

	/** WP order: JSON > POST > GET > URL. */
	public function get_param( $key ) {
		foreach ( array( 'JSON', 'POST', 'GET', 'URL' ) as $bucket ) {
			if ( array_key_exists( $key, $this->params[ $bucket ] ) ) {
				return $this->params[ $bucket ][ $key ];
			}
		}
		return null;
	}

	public function get_params() {
		return array_merge(
			$this->params['URL'],
			$this->params['GET'],
			$this->params['POST'],
			$this->params['JSON']
		);
	}

	#[\ReturnTypeWillChange]
	public function offsetExists( $offset ) {
		return null !== $this->get_param( $offset );
	}

	#[\ReturnTypeWillChange]
	public function offsetGet( $offset ) {
		return $this->get_param( $offset );
	}

	#[\ReturnTypeWillChange]
	public function offsetSet( $offset, $value ) {
		$this->params['URL'][ $offset ] = $value;
	}

	#[\ReturnTypeWillChange]
	public function offsetUnset( $offset ) {
		unset( $this->params['URL'][ $offset ] );
	}
}

function register_rest_route( $namespace, $route, $args = array(), $override = false ) {
	$args = (array) $args;
	// Single-endpoint registrations come as one assoc; normalize to list.
	if ( isset( $args['callback'] ) || isset( $args['methods'] ) ) {
		$args = array( $args );
	}
	foreach ( $args as $ep ) {
		// WP accepts 'GET', ['GET','POST'], or comma strings like 'POST, PUT'
		// (WP_REST_Server constants). Normalize to a flat uppercase list.
		$methods = array();
		foreach ( (array) ( $ep['methods'] ?? 'GET' ) as $mm ) {
			foreach ( explode( ',', (string) $mm ) as $one ) {
				$one = strtoupper( trim( $one ) );
				if ( '' !== $one ) {
					$methods[] = $one;
				}
			}
		}
		$GLOBALS['cc_rest_routes'][] = array(
			'ns'      => trim( $namespace, '/' ),
			'route'   => $route,
			'methods' => $methods ? $methods : array( 'GET' ),
			'cb'      => $ep['callback'] ?? '__return_true',
			'perm'    => $ep['permission_callback'] ?? '__return_true',
		);
	}
	return true;
}

function rest_url( $path = '' ) {
	return '/' . ltrim( (string) $path, '/' );
}

function rest_ensure_response( $response ) {
	return $response; // arrays pass through; WP_Error handled by dispatcher
}

/**
 * Dispatch one REST request. Returns array{status,payload} or lets the
 * callback exit() itself (media stream / thumbs).
 */
function cc_rest_dispatch( $method, $path ) {
	$method       = strtoupper( $method );
	$path         = trim( preg_replace( '#/+#', '/', (string) $path ), '/' );
	$path_matched = false;
	foreach ( (array) ( $GLOBALS['cc_rest_routes'] ?? array() ) as $r ) {
		$pattern = '#^' . $r['ns'] . $r['route'] . '$#';
		if ( ! preg_match( $pattern, $path, $m ) ) {
			continue;
		}
		// Route path may be registered several times with different methods
		// (e.g. GET + POST /settings) — skip this entry, let the next match.
		if ( ! in_array( $method, $r['methods'], true ) && ! in_array( 'ANY', $r['methods'], true ) ) {
			$path_matched = true;
			continue;
		}
		$req = new WP_REST_Request( $method, '/' . $path );
		$url_params = array();
		foreach ( $m as $k => $v ) {
			if ( is_string( $k ) ) {
				$url_params[ $k ] = $v;
			}
		}
		$req->set_url_params( $url_params );
		$req->set_query_params( $_GET );
		$req->set_body_params( $_POST );
		$ctype = (string) ( $_SERVER['CONTENT_TYPE'] ?? '' );
		if ( false !== strpos( $ctype, 'application/json' ) ) {
			$json = json_decode( (string) file_get_contents( 'php://input' ), true );
			$req->set_json_params( is_array( $json ) ? $json : array() );
		}

		$perm = call_user_func( $r['perm'], $req );
		if ( is_wp_error( $perm ) ) {
			$payload = $perm->as_rest_payload();
			return array( (int) $payload['data']['status'], $payload );
		}
		if ( true !== $perm ) {
			return array( 403, array( 'code' => 'rest_forbidden', 'message' => 'Akses ditolak.', 'data' => array( 'status' => 403 ) ) );
		}

		try {
			$res = call_user_func( $r['cb'], $req );
		} catch ( Throwable $e ) {
			return array( 500, array( 'code' => 'cc_internal', 'message' => 'Kesalahan server: ' . $e->getMessage(), 'data' => array( 'status' => 500 ) ) );
		}
		if ( is_wp_error( $res ) ) {
			$payload = $res->as_rest_payload();
			return array( (int) $payload['data']['status'], $payload );
		}
		return array( 200, is_array( $res ) ? $res : array( 'data' => $res ) );
	}
	if ( $path_matched ) {
		return array( 405, array( 'code' => 'rest_no_route', 'message' => 'Method tidak diizinkan.', 'data' => array( 'status' => 405 ) ) );
	}
	return array( 404, array( 'code' => 'rest_no_route', 'message' => 'Route tidak ditemukan.', 'data' => array( 'status' => 404 ) ) );
}

/* =====================================================================
 * HTTP client — wp_remote_* over curl
 * =================================================================== */

function cc_http_request( $url, $args = array(), $method = 'POST' ) {
	if ( ! function_exists( 'curl_init' ) ) {
		return new WP_Error( 'cc_http', 'Ekstensi cURL tidak tersedia.' );
	}
	$headers = array();
	foreach ( (array) ( $args['headers'] ?? array() ) as $k => $v ) {
		$headers[] = $k . ': ' . $v;
	}
	$ch = curl_init();
	curl_setopt_array(
		$ch,
		array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => (int) ( $args['timeout'] ?? 30 ),
			CURLOPT_CUSTOMREQUEST  => $method,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_POSTFIELDS     => (string) ( $args['body'] ?? '' ),
			CURLOPT_SSL_VERIFYPEER => true,
		)
	);
	$body  = curl_exec( $ch );
	$errno = curl_errno( $ch );
	$err   = curl_error( $ch );
	$code  = (int) curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
	curl_close( $ch );
	if ( $errno || false === $body ) {
		return new WP_Error( 'cc_http', 'HTTP request gagal: ' . ( $err ?: 'curl error ' . $errno ) );
	}
	return array(
		'headers'  => array(),
		'body'     => $body,
		'response' => array( 'code' => $code, 'message' => '' ),
	);
}

function wp_remote_post( $url, $args = array() ) {
	return cc_http_request( $url, $args, 'POST' );
}

function wp_remote_get( $url, $args = array() ) {
	return cc_http_request( $url, $args, 'GET' );
}

function wp_remote_retrieve_body( $response ) {
	return is_array( $response ) ? (string) ( $response['body'] ?? '' ) : '';
}

function wp_remote_retrieve_response_code( $response ) {
	return is_array( $response ) ? (int) ( $response['response']['code'] ?? 0 ) : 0;
}

/* =====================================================================
 * Sanitize / escape / markup helpers
 * =================================================================== */

function absint( $maybeint ) {
	return abs( (int) $maybeint );
}

function sanitize_key( $key ) {
	return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $key ) );
}

function sanitize_text_field( $str ) {
	$str = (string) $str;
	$str = wp_strip_all_tags( $str );
	$str = preg_replace( '/[\r\n\t\x0B\x0C]+/', ' ', $str );
	return trim( $str );
}

function sanitize_textarea_field( $str ) {
	$str = (string) $str;
	$str = wp_strip_all_tags( $str );
	$str = str_replace( array( "\r\n", "\r" ), "\n", $str );
	return trim( $str );
}

function sanitize_file_name( $name ) {
	$name = (string) $name;
	$name = preg_replace( '/[\x00-\x1f\x7f]/', '', $name );
	$name = str_replace( array( '<', '>', ':', '"', '/', '\\', '|', '?', '*' ), '', $name );
	$name = preg_replace( '/\.{2,}/', '.', $name );
	$name = trim( $name, " ." );
	return '' === $name ? 'file' : $name;
}

function sanitize_title( $title ) {
	$t = strtolower( (string) $title );
	$t = preg_replace( '/[^a-z0-9 _\-]/', '', $t );
	$t = preg_replace( '/[\s_]+/', '-', trim( $t ) );
	return trim( $t, '-' );
}

function esc_html( $text ) {
	return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function esc_attr( $text ) {
	return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function esc_textarea( $text ) {
	return esc_html( $text );
}

/** Allowed schemes + relative paths only — javascript:/data: dropped. */
function esc_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( preg_match( '#^([a-z][a-z0-9+.-]*):#i', $url, $m ) ) {
		$scheme = strtolower( $m[1] );
		if ( ! in_array( $scheme, array( 'http', 'https', 'mailto' ), true ) ) {
			return '';
		}
	}
	return htmlspecialchars( $url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function esc_url_raw( $url ) {
	return esc_url( $url );
}

function wp_strip_all_tags( $text, $remove_breaks = false ) {
	$text = (string) $text;
	$text = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $text );
	$text = strip_tags( $text );
	if ( $remove_breaks ) {
		$text = preg_replace( '/[\r\n\t ]+/', ' ', $text );
	}
	return trim( $text );
}

/**
 * wp_kses subset — DOMDocument walk keeping only allowlisted tags and
 * per-tag allowlisted attributes. Disallowed tags are unwrapped (their
 * children kept), matching WP behavior closely enough for chat bodies.
 */
function wp_kses( $html, $allowed_html ) {
	$html = (string) $html;
	if ( '' === $html ) {
		return '';
	}
	$allowed = array();
	foreach ( (array) $allowed_html as $tag => $attrs ) {
		$allowed[ strtolower( $tag ) ] = array_map( 'strtolower', array_keys( (array) $attrs ) );
	}
	$doc = new DOMDocument();
	$prev = libxml_use_internal_errors( true );
	$doc->loadHTML( '<?xml encoding="UTF-8"><div id="cc-kses-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	libxml_use_internal_errors( $prev );
	$xp   = new DOMXPath( $doc );
	$root = $xp->query( '//*[@id="cc-kses-root"]' )->item( 0 );
	if ( ! $root ) {
		return esc_html( $html );
	}
	$clean = function ( $node ) use ( &$clean, $allowed, $doc ) {
		$children = array();
		foreach ( iterator_to_array( $node->childNodes ) as $ch ) {
			$children[] = $ch;
		}
		foreach ( $children as $ch ) {
			if ( XML_ELEMENT_NODE === $ch->nodeType ) {
				$tag = strtolower( $ch->nodeName );
				if ( ! array_key_exists( $tag, $allowed ) ) {
					// Unwrap: move children up, drop the element.
					while ( $ch->firstChild ) {
						$node->insertBefore( $ch->firstChild, $ch );
					}
					$node->removeChild( $ch );
					continue;
				}
				// Strip non-allowlisted attributes.
				foreach ( iterator_to_array( $ch->attributes ) as $attr ) {
					if ( ! in_array( strtolower( $attr->nodeName ), $allowed[ $tag ], true ) ) {
						$ch->removeAttribute( $attr->nodeName );
					}
				}
				$clean( $ch );
			}
		}
	};
	$clean( $root );
	$out = '';
	foreach ( $root->childNodes as $ch ) {
		$out .= $doc->saveHTML( $ch );
	}
	return $out;
}

function wp_kses_allowed_html() {
	return array(
		'a'          => array( 'href' => true, 'target' => true, 'rel' => true ),
		'strong'     => array(),
		'b'          => array(),
		'em'         => array(),
		'i'          => array(),
		'code'       => array(),
		'pre'        => array(),
		'br'         => array(),
		'p'          => array(),
		'ul'         => array(),
		'ol'         => array(),
		'li'         => array(),
		'blockquote' => array(),
	);
}

function wp_kses_post( $html ) {
	return wp_kses( $html, wp_kses_allowed_html() );
}

/** Simplified wpautop — blank-line blocks → <p>, lone \n → <br>. */
function wpautop( $text ) {
	$text = trim( (string) $text );
	if ( '' === $text ) {
		return '';
	}
	$blocks = preg_split( '/\n[ \t]*\n/', $text );
	$out    = array();
	foreach ( (array) $blocks as $b ) {
		$b = trim( $b );
		if ( '' === $b ) {
			continue;
		}
		// Leave block-level markup untouched.
		if ( preg_match( '#^\s*<(p|div|ul|ol|li|pre|blockquote|table|h[1-6]|video)\b#i', $b ) ) {
			$out[] = $b;
			continue;
		}
		$b      = nl2br( $b, false );
		$out[]  = '<p>' . $b . '</p>';
	}
	return implode( "\n", $out );
}

/** Autolink bare URLs, skipping existing tags/anchors. */
function make_clickable( $text ) {
	return preg_replace_callback(
		'#(<a\b[^>]*>.*?</a>|<[^>]+>)|(\bhttps?://[^\s<]+)#i',
		function ( $m ) {
			if ( '' !== ( $m[1] ?? '' ) ) {
				return $m[0];
			}
			$url   = rtrim( $m[0], '.,;:!?)' );
			$trail = substr( $m[0], strlen( $url ) );
			return '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">'
				. esc_html( $url ) . '</a>' . $trail;
		},
		(string) $text
	);
}

function trailingslashit( $string ) {
	return untrailingslashit( $string ) . '/';
}

function untrailingslashit( $string ) {
	return rtrim( (string) $string, '/\\' );
}

function wp_is_stream( $path ) {
	$scheme_separator = strpos( (string) $path, '://' );
	if ( false === $scheme_separator ) {
		return false;
	}
	return in_array( substr( (string) $path, 0, $scheme_separator ), stream_get_wrappers(), true );
}

function wp_normalize_path( $path ) {
	$path    = (string) $path;
	$wrapper = '';
	// Stream wrappers (https://…, file://…) keep their scheme intact —
	// collapsing '//' here would corrupt URLs like YouTube sources.
	if ( wp_is_stream( $path ) ) {
		list( $wrapper, $path ) = explode( '://', $path, 2 );
		$wrapper .= '://';
	}
	$path = str_replace( '\\', '/', $path );
	$path = (string) preg_replace( '|(?<=.)/+|', '/', $path );
	return $wrapper . $path;
}

function wp_json_encode( $data, $flags = 0, $depth = 512 ) {
	return json_encode( $data, $flags, $depth );
}

function wp_unslash( $value ) {
	return $value; // no magic_quotes on modern PHP
}

function selected( $selected, $current = true, $display = true ) {
	return cc_attr_helper( 'selected', $selected, $current, $display );
}

function checked( $checked, $current = true, $display = true ) {
	return cc_attr_helper( 'checked', $checked, $current, $display );
}

function disabled( $disabled, $current = true, $display = true ) {
	return cc_attr_helper( 'disabled', $disabled, $current, $display );
}

function cc_attr_helper( $attr, $a, $b, $display ) {
	$out = (string) $a === (string) $b ? ' ' . $attr . '="' . $attr . '"' : '';
	if ( $display ) {
		echo $out;
	}
	return $out;
}

/* =====================================================================
 * Time / files / HTTP status / salt
 * =================================================================== */

function current_time( $type, $gmt = 0 ) {
	// Timestamps are stored in UTC — consistent with the gmdate()
	// cutoffs in cc_jobs_reap.
	if ( 'timestamp' === $type || 'U' === $type ) {
		return time();
	}
	return gmdate( 'Y-m-d H:i:s' );
}

function wp_mkdir_p( $target ) {
	if ( is_dir( $target ) ) {
		return true;
	}
	return @mkdir( $target, 0777, true ) || is_dir( $target );
}

function status_header( $code, $description = '' ) {
	http_response_code( (int) $code );
}

/** Stable per-install secret → HMAC keys. */
function cc_secret_blob() {
	static $blob = null;
	if ( null === $blob ) {
		$file = CC_DATA_DIR . '/secret';
		if ( file_exists( $file ) ) {
			$blob = trim( (string) file_get_contents( $file ) );
		}
		if ( empty( $blob ) ) {
			wp_mkdir_p( CC_DATA_DIR );
			$blob = bin2hex( random_bytes( 48 ) );
			file_put_contents( $file, $blob );
			@chmod( $file, 0600 );
		}
	}
	return $blob;
}

function wp_salt( $scheme = 'auth' ) {
	return hash_hmac( 'sha256', (string) $scheme, cc_secret_blob() );
}

function wp_die( $message = '', $title = '', $args = array() ) {
	$code = is_array( $args ) && isset( $args['response'] ) ? (int) $args['response'] : 500;
	status_header( $code );
	echo is_string( $message ) ? $message : '';
	exit;
}

function wp_upload_dir() {
	$base = trailingslashit( CC_DATA_DIR ) . 'uploads';
	wp_mkdir_p( $base );
	return array(
		'path'    => $base,
		'basedir' => $base,
		'url'     => '/uploads',
		'baseurl' => '/uploads',
		'subdir'  => '',
		'error'   => false,
	);
}

/* =====================================================================
 * Auth — single-admin desktop model
 * =================================================================== */

function get_current_user_id() {
	return 1;
}

function current_user_can( $cap, ...$args ) {
	return true;
}

function user_can( $user, $cap, ...$args ) {
	return true;
}

function is_user_logged_in() {
	return true;
}

function wp_get_current_user() {
	return (object) array( 'ID' => 1, 'display_name' => 'Admin', 'user_login' => 'admin' );
}

function wp_create_nonce( $action = -1 ) {
	return substr( wp_salt( 'nonce' . $action ), 0, 12 );
}

/* =====================================================================
 * Paths / misc
 * =================================================================== */

/** Theme-root equivalent — inc/, views/, bin/ live here. */
function get_template_directory() {
	return dirname( __DIR__ ); // app/
}

function get_template_directory_uri() {
	return '';
}

/** views/ partial include — used by public/index.php. */
function get_template_part( $slug, $name = null ) {
	$path = get_template_directory() . '/' . trim( $slug, '/' ) . ( $name ? '-' . $name : '' ) . '.php';
	if ( file_exists( $path ) ) {
		require $path;
	}
}

function admin_url( $path = '' ) {
	return '/' . ltrim( (string) $path, '/' );
}

function home_url( $path = '' ) {
	return '/' . ltrim( (string) $path, '/' );
}

function wp_safe_redirect( $location, $status = 302 ) {
	header( 'Location: ' . $location, true, (int) $status );
	return true;
}

function wp_login_url( $redirect = '' ) {
	return '/';
}

function add_query_arg( ...$args ) {
	// WP signature: (key, value, url) | (assoc, url) | (url)
	if ( 1 === count( $args ) ) {
		return $args[0];
	}
	if ( 2 === count( $args ) ) {
		$qs  = $args[0];
		$url = $args[1];
	} else {
		$qs  = array( $args[0] => $args[1] );
		$url = $args[2];
	}
	return $url . ( false === strpos( $url, '?' ) ? '?' : '&' ) . http_build_query( (array) $qs );
}

function add_menu_page( ...$args ) {
	return 'cc-settings';
}

function submit_button( $text = 'Simpan', $type = 'primary', $name = 'submit' ) {
	echo '<button type="submit" class="button">' . esc_html( $text ) . '</button>';
}

function check_admin_referer( $action = -1, $query_arg = '_wpnonce' ) {
	return 1;
}

function wp_nonce_field( $action = -1, $name = '_wpnonce', $referer = true, $display = true ) {
	$out = '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( wp_create_nonce( $action ) ) . '">';
	if ( $display ) {
		echo $out;
	}
	return $out;
}

function add_theme_support( $feature ) {
	return true;
}

function wp_enqueue_style( ...$args ) {
	return true;
}

function wp_enqueue_script( ...$args ) {
	return true;
}

function wp_localize_script( ...$args ) {
	return true;
}

function dbDelta( $sql = '' ) {
	return array();
}

/* =====================================================================
 * Latent helper missing upstream — path → signed stream URL
 * =================================================================== */

function cc_path_to_url( $path ) {
	$path = wp_normalize_path( (string) $path );
	if ( '' === $path || ! file_exists( $path ) || ! function_exists( 'cc_media_url' ) ) {
		return '';
	}
	return cc_media_url( $path );
}
