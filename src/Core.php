<?php

namespace Apiki\SEO\REST;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

class Core extends Loader
{
	public function initialize()
	{
		$controllers = array(
			'Posts',
			'Taxonomies',
		);

		$this->load_controllers( $controllers );
	}

	public function activate()
	{

	}

	public function scripts_admin()
	{

	}

	public function styles_admin()
	{

	}
}
