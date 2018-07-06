<?php

namespace Apiki\SEO\REST\Controller;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use Apiki\SEO\REST\Core;
use Apiki\SEO\REST\Model\Term;
use WPSEO_Options;

class Taxonomies
{
	public $options = array();

	public function __construct()
	{
		add_action( 'rest_api_init', array( $this, 'add_custom_rest_fields' ) );
	}

	public function get_taxonomies()
	{
		$taxonomies = get_taxonomies([
			'public'       => true,
			'show_in_rest' => true,
		]);

		return array_values( $taxonomies );
	}

	public function add_custom_rest_fields()
	{
		$this->options = WPSEO_Options::get_options( array( 'wpseo_social', 'wpseo_taxonomy_meta' ) );

		register_rest_field(
			$this->get_taxonomies(),
			'seo',
			array(
				'get_callback'    => array( $this, 'get_rest_value' ),
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}

	public function get_rest_value( $object )
	{
		$model = new Term( $object, $this->options );

		return array(
			'open_graph' => $model->get_open_graph(),
			'twitter'    => $model->get_twitter(),
			'meta'       => $model->get_metas(),
		);
	}
}
