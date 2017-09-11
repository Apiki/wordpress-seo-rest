<?php

namespace Apiki\SEO\REST;

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use ReflectionClass;

abstract class Loader
{
	/**
	 * The pages where must print script.
	 *
	 * @var string
	 */
	public $pages_enqueue_media = array(
		'post.php',
		'post-new.php',
		'themes.php',
	);

	/**
	 * Base path used for include files.
	 *
	 * @var string
	 */
	protected static $root_file;

	/**
	 * SLUG plugin.
	 *
	 * @var string
	 */
	const SLUG = 'wordpress-seo-rest';

	public function __construct( $file = false )
	{
		add_action( 'admin_enqueue_scripts', array( &$this, 'scripts_admin' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'styles_admin' ) );
		add_action( 'init', array( &$this, 'load_textdomain' ) );

		self::$root_file[ static::SLUG ] = $file;

		$this->initialize();
	}

	/**
	 * Initialize.
	 */
	public function initialize()
	{

	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain()
	{
		load_plugin_textdomain( static::SLUG, false, self::plugin_rel_path( 'languages' ) );
	}

	/**
	 * Prepare the item for the REST response.
	 *
	 * @param array $controllers list of controllers.
	 * @param bool $activate used for add capabilities in creating instance.
	 */
	public function load_controllers( $controllers, $activate = false )
	{
		$namespace = $this->get_namespace();

		foreach ( $controllers as $name ) {
			$this->_handle_instance( sprintf( "{$namespace}\Controller\%s", $name ), $activate );
		}
	}

	/**
	 * Get namespace this class.
	 *
	 * @return string
	 */
	public function get_namespace()
	{
		return ( new ReflectionClass( $this ) )->getNamespaceName();
	}

	/**
	 * Enqueue script media.
	 */
	public function load_wp_media()
	{
		global $pagenow;

		if ( did_action( 'wp_enqueue_media' ) ) {
			return;
		}

		if ( in_array( $pagenow, $this->pages_enqueue_media, true ) ) {
			wp_enqueue_media();
		}
	}

	/**
	 * Scripts for admin WordPress.
	 */
	public function scripts_admin()
	{

	}

	/**
	 * Styles for admin WordPress.
	 */
	public function styles_admin()
	{

	}

	/**
	 * Get root file per static::SLUG.
	 *
	 * @return string
	 */
	public static function get_root_file()
	{
		return self::$root_file[ static::SLUG ];
	}

	/**
	 * Get absolute path.
	 *
	 * @param string $path
	 * @return string
	 */
	public static function plugin_dir_path( $path )
	{
		return plugin_dir_path( self::get_root_file() ) . $path;
	}

	/**
	 * Get path base plugin.
	 *
	 * @param string $path
	 * @return string
	 */
	public static function plugin_rel_path( $path )
	{
		return dirname( plugin_basename( self::get_root_file() ) ) . '/' . $path;
	}

	/**
	 * Get plugin url with path of increment.
	 *
	 * @param string $path
	 * @return string
	 */
	public static function plugins_url( $path )
	{
		return plugins_url( $path, self::get_root_file() );
	}

	/**
	 * Get filemtime.
	 *
	 * @param string $path
	 * @return string
	 */
	public static function filemtime( $path )
	{
		return filemtime( self::plugin_dir_path( $path ) );
	}

	/**
	 * Cretae instance of controllers.
	 *
	 * @param string $class class name.
	 * @param bool $activate used for add capabilities in creating instance.
	 */
	private function _handle_instance( $class, $activate = false )
	{
		$instance = new $class( $activate );

		if ( $activate ) {
			$instance->add_capabilities( array( 'administrator', 'editor' ) );
			unset( $instance );
		}
	}
}
