<?php

namespace Apiki\SEO\REST\Model;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use Apiki\SEO\REST\Core;
use WPSEO_Options;
use WPSEO_Meta;

class Twitter extends Social
{
	public function get_title()
	{
		$title = WPSEO_Meta::get_value( 'twitter-title', $this->post->ID );

		if ( ! $title ) {
			$title = parent::get_title();
		}

		return trim( apply_filters( 'wpseo_twitter_title', $title ) );
	}

	public function get_description()
	{
		$desc = $this->get_meta_description( 'twitter-description' );

		if ( ! $desc ) {
			$desc = parent::get_description();
		}

		return trim( apply_filters( 'wpseo_opengraph_desc', $desc ) );
	}

	public function get_card_type()
	{
		$type = $this->options['twitter_card_type'];

		if ( has_shortcode( $this->post->post_content, 'gallery' ) ) {
			$type = 'summary_large_image';
		}

		return apply_filters( 'wpseo_twitter_card_type', $type );
	}

	public function get_image()
	{
		$image = $this->get_meta_image_by_keys( array( 'twitter-image', 'opengraph-image' ) );

		if ( $image ) {
			return $image;
		}

		return $this->get_thumbnail_image( apply_filters( 'wpseo_twitter_image_size', 'full' ) );
	}

	public function get_array()
	{
		return array(
			'title'       => $this->get_title(),
			'description' => $this->get_description(),
			'type'        => $this->get_card_type(),
			'image'       => $this->get_image(),
		);
	}
}
