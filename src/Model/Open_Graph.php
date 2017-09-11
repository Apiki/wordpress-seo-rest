<?php

namespace Apiki\SEO\REST\Model;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use Apiki\SEO\REST\Core;
use WPSEO_Options;
use WPSEO_Meta;

class Open_Graph extends Social
{
	public function get_title()
	{
		$title = WPSEO_Meta::get_value( 'opengraph-title', $this->post->ID );

		if ( ! $title ) {
			$title = parent::get_title();
		}

		return trim( apply_filters( 'wpseo_opengraph_title', $title ) );
	}

	public function get_description()
	{
		$desc = $this->get_meta_description( 'opengraph-description' );

		if ( ! $desc ) {
			$desc = parent::get_description();
		}

		return trim( apply_filters( 'wpseo_opengraph_desc', $desc ) );
	}

	public function get_type()
	{
		$type = WPSEO_Meta::get_value( 'og_type' );

		if ( ! $type ) {
			$type = 'article';
		}

		return apply_filters( 'wpseo_opengraph_type', $type );
	}

	public function get_locale()
	{
		return $this->locale( false );
	}

	public function get_url()
	{
		$url = WPSEO_Meta::get_value( 'canonical' );

		if ( ! $url ) {
			$url = get_permalink( $this->post->ID );
		}

		return apply_filters( 'wpseo_opengraph_url', $url );
	}

	public function get_site_name()
	{
		return apply_filters( 'wpseo_opengraph_site_name', get_bloginfo( 'name' ) );
	}

	public function get_image_object()
	{
		$image = $this->get_meta_image_by_keys( array( 'opengraph-image' ) );

		if ( $image ) {
			return array( 'src' => $image );
		}

		$thumb = $this->get_thumbnail_src( apply_filters( 'wpseo_opengraph_image_size', 'original' ) );

		if ( ! $thumb ) {
			return false;
		}

		return array(
			'src'    => $thumb[0],
			'width'  => $thumb[1],
			'height' => $thumb[2],
		);
	}

	public function get_modified_time()
	{
		return get_the_modified_date( DATE_W3C );
	}

	public function get_published_time()
	{
		return get_the_date( DATE_W3C );
	}

	public function get_array()
	{
		return array(
			'title'          => $this->get_title(),
			'description'    => $this->get_description(),
			'type'           => $this->get_type(),
			'locale'         => $this->get_locale(),
			'url'            => $this->get_url(),
			'site_name'      => $this->get_site_name(),
			'image'          => $this->get_image_object(),
			'modified_time'  => $this->get_modified_time(),
			'published_time' => $this->get_published_time(),
		);
	}
}
