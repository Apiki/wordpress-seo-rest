<?php

namespace Apiki\SEO\REST\Model;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use WPSEO_Taxonomy_Meta;

class Term
{
	/**
	 * Yoast metas
	 *
	 * @var array
	 */
	public $metas;

	/**
	 * Yoast options
	 *
	 * @var array
	 */
	public $options;

	/**
	 * Default term fields
	 *
	 * @var array
	 */
	public $term;

	public function __construct( $term, $options )
	{
		$this->options = $options;
		$this->metas   = $this->get_yoast_metas( $term['taxonomy'], $term['id'] );
		$this->term    = $term;
	}

	public function get_open_graph()
	{
		return array(
			'title'       => $this->get_title(),
			'description' => $this->get_description(),
			'type'        => 'object',
			'image'       => $this->get_image(),
		);
	}

	public function get_twitter()
	{
		return array(
			'title'       => $this->get_title( 'twitter' ),
			'description' => $this->get_description( 'twitter' ),
			'type'        => $this->options['twitter_card_type'],
			'image'       => $this->get_image( 'twitter' ),
		);
	}

	public function get_metas()
	{
		return array(
			'title'       => $this->get_title( 'base' ),
			'description' => $this->get_description( 'base' ),
		);
	}

	private function get_yoast_metas( $taxonomy, $term_id )
	{
		if ( isset( $this->options[ $taxonomy ][ $term_id ] ) ) {
			return array_merge( WPSEO_Taxonomy_Meta::$defaults_per_term, $this->options[ $taxonomy ][ $term_id ] );
		}

		return WPSEO_Taxonomy_Meta::$defaults_per_term;
	}

	private function get_title( $prefix = 'opengraph' )
	{
		$meta  = 'base' === $prefix ? 'wpseo_title' : "wpseo_{$prefix}-title";
		$title = $this->metas[ $meta ];

		if ( empty( $title ) ) {
			$title = $this->term['name'];
		}

		return $title;
	}

	private function get_description( $prefix = 'opengraph' )
	{
		$meta        = 'base' === $prefix ? 'wpseo_desc' : "wpseo_{$prefix}-description";
		$description = $this->metas[ $meta ];

		if ( empty( $description ) ) {
			$description = $this->term['description'];
		}

		return $description;
	}

	private function get_image( $prefix = 'opengraph' )
	{
		return $this->metas[ "wpseo_{$prefix}-image" ];
	}
}
