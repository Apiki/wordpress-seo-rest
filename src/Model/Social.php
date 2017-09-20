<?php

namespace Apiki\SEO\REST\Model;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

require WP_PLUGIN_DIR . '/wordpress-seo/frontend/class-opengraph.php';

use Apiki\SEO\REST\Core;
use WPSEO_Options;
use WPSEO_Meta;
use WPSEO_OpenGraph;

class Social extends WPSEO_OpenGraph
{
	/**
	 * name post
	 *
	 * @var object
	 */
	public $post;

	public function __construct( $post, $options )
	{
		$this->post    = $post;
		$this->options = $options;
	}

	public function get_title()
	{
		$title = WPSEO_Meta::get_value( 'title', $this->post->ID );

		if ( $title ) {
			return $title;
		}

		return wpseo_replace_vars( $this->options[ 'title-' . $this->post->post_type ], $this->post );
	}

	public function get_replace_vars( $value, $is_strip_shortcodes = false )
	{
		$value = wpseo_replace_vars( $value, $this->post );

		if ( $is_strip_shortcodes ) {
			$value = strip_shortcodes( $value );
		}

		return $value;
	}

	public function get_meta_description( $meta_key )
	{
		$desc = WPSEO_Meta::get_value( $meta_key, $this->post->ID );

		if ( ! $desc ) {
			return false;
		}

		return $this->get_replace_vars( $desc, true );
	}

	public function get_the_excerpt()
	{
		return str_replace( '[&hellip;]', '&hellip;', strip_tags( get_the_excerpt( $this->post ) ) );
	}

	public function get_description()
	{
		$desc = WPSEO_Meta::get_value( 'metadesc', $this->post->ID );

		if ( $desc ) {
			return $this->get_replace_vars( $desc, true );
		}

		return strip_shortcodes( $this->get_the_excerpt() );
	}

	public function get_meta_image_by_keys( $keys )
	{
		foreach ( $keys as $tag ) {
			$img = WPSEO_Meta::get_value( $tag, $this->post->ID );

			if ( $img ) {
				return $img;
			}
		}

		return false;
	}

	public function get_thumbnail_image( $size = 'full' )
	{
		$thumb = $this->get_thumbnail_src( $size );

		if ( ! $thumb ) {
			return false;
		}

		return $thumb[0];
	}

	public function get_thumbnail_src( $size = 'full' )
	{
		if ( ! has_post_thumbnail( $this->post->ID ) ) {
			return false;
		}

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->post->ID ), $size );

		if ( ! is_array( $image ) ) {
			return false;
		}

		return $image;
	}
}
