<?php

namespace Apiki\SEO\REST\Controller;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use Apiki\SEO\REST\Core;
use Apiki\SEO\REST\Model\Open_Graph;
use Apiki\SEO\REST\Model\Twitter;
use WPSEO_Options;

class Fields
{
	public $options = array();

	public function __construct()
	{
		add_action( 'rest_api_init', array( &$this, 'rest_fields_post_types' ) );
	}

	public function get_post_types()
	{
		$types = get_post_types( array( 'public' => true ) );

		unset( $types['attachment'] );
		unset( $types['revision'] );
		unset( $types['nav_menu_item'] );

		return $types;
	}

	public function rest_fields_post_types()
	{
		$this->options = WPSEO_Options::get_options( array( 'wpseo_titles', 'wpseo_social' ) );

		register_rest_field(
			$this->get_post_types(),
			'seo',
			array(
				'get_callback'    => array( &$this, 'get_rest_value_post_type' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}

	public function get_rest_value_post_type( $object )
	{
		$instances = $this->get_instances( $object );

		return array(
			'open_graph' => $instances['open_graph']->get_array(),
			'twitter'    => $instances['twitter']->get_array(),
		);
	}

	public function get_instances( $object )
	{
		$post = get_post( $object['id'] );

		return array(
			'open_graph' => new Open_Graph( $post, $this->options ),
			'twitter'    => new Twitter( $post, $this->options ),
		);
	}
}
