<?php

namespace Apiki\SEO\REST\Model;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

class Meta extends Social
{
	public function get_description()
	{
		return trim( apply_filters( 'wpseo_meta_desc', parent::get_description() ) );
	}

	public function get_array()
	{
		return array(
			'description' => $this->get_description(),
		);
	}
}
