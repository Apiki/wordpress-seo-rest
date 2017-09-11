<?php

namespace Apiki\SEO\REST\Helper;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

class Utils
{
	public static function get_key( $list, $key, $default = false )
	{
		return isset( $list[ $key ] ) ? $list[ $key ] : $default;
	}

	public static function http_response_code( $code = 200 )
	{
		header( 'X-PHP-Response-Code: ' . $code, true, $code );
	}
}
