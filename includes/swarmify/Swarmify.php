<?php

namespace SmartvideoWoocommercePlugin\Swarmify;

use SmartvideoWoocommercePlugin\Admin\Setup;


/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://swarmify.com/
 * @since      1.0.0
 *
 * @package    Swarmify
 * @subpackage Swarmify/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Swarmify
 * @subpackage Swarmify/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Swarmify {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SWARMIFY_PLUGIN_VERSION' ) ) {
			$this->version = SWARMIFY_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'SmartVideo';

		// Should be handled via `use`?
        $this->load_dependencies();
        $this->load_config_from_constants();

		if ( is_admin() ) {
			new Setup();

			// $this->define_admin_hooks();
		}

		$this->set_locale();
		$this->define_public_hooks();

    }
    
	/**
	 * Load any configuration defined by constants in the wp_config file
	 *
	 * @since    2.0.12
	 * @access   private
	 */
    private function load_config_from_constants() {

        // Check for configuration via globals in wp_config.php
        if ( defined( 'SWARMIFY_CDN_KEY' ) ) {
            update_option( 'swarmify_cdn_key', constant( 'SWARMIFY_CDN_KEY') );
            update_option( 'swarmify_status','on');
        }
    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Orchestrates the hooks of the plugin.
	 * - Swarmify_i18n. Defines internationalization functionality.
	 * - Swarmify_Admin. Defines all hooks for the admin area.
	 * - Swarmify_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		// /**
		//  * The class responsible for orchestrating the actions and filters of the
		//  * core plugin.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-swarmify-loader.php';

        // /**
		//  * The class responsible for activating the SwarmifyUploadAccelerator.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-swarmify-upload.php';

		// /**
		//  * The class responsible for defining internationalization functionality
		//  * of the plugin.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-swarmify-i18n.php';

		// /**
		//  * The class responsible for defining all actions that occur in the admin area.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-swarmify-admin.php';

		// /**
		//  * The class responsible for defining all actions that occur in the public-facing
		//  * side of the site.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-swarmify-public.php';

		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'init', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Swarmify_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin,'option_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin,'plugin_register_settings' );
		$this->loader->add_action( 'widgets_init', $plugin_admin,'load_widget' );

		$this->loader->add_action('media_buttons', $plugin_admin,'add_video_button', 15);
		$this->loader->add_action( 'admin_footer',  $plugin_admin, 'add_video_lightbox_html');

		add_shortcode( 'smartvideo', array($plugin_admin,'smartvideo_shortcode') );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		// FIXME: register widget?
		// $plugin_public = new Swarmify_Public( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action('wp_head', $this, 'swarmify_script');
		$this->loader->add_action('admin_head', $this, 'swarmify_script');
	}

	/**
	 * Echo the swarmdetect settings and script
	 */
	public function swarmify_script(){
		$cdn_key = get_option('swarmify_cdn_key');
		$swarmify_status = get_option('swarmify_status', 'on'); // FIXME!!!!!
        $youtube = get_option('swarmify_toggle_youtube');
        $youtube_cc = get_option('swarmify_toggle_youtube_cc');
		$layout = get_option('swarmify_toggle_layout');
		$bgoptimize = get_option('swarmify_toggle_bgvideo');
		$theme_primarycolor = get_option('swarmify_theme_primarycolor');
        $theme_button = get_option('swarmify_theme_button');
        $watermark = get_option('swarmify_watermark');
        $ads_vasturl = get_option('swarmify_ads_vasturl');
		
		if($swarmify_status == 'on' && $cdn_key !== ''){
			$status = true;
		}else{
			$status = false;
		}

        // Configure `autoreplace` object
        $autoreplaceObject = new \stdClass();

		if($youtube == 'on'){
            $autoreplaceObject->youtube = true;
		}else{
            $autoreplaceObject->youtube = false;
        }
        
        if($youtube_cc == 'on') {
            $autoreplaceObject->youtubecaptions = true;
        }else{
            $autoreplaceObject->youtubecaptions = false;
        }

        if($bgoptimize == 'on'){
            $autoreplaceObject->videotag = true;
		}else{
            $autoreplaceObject->videotag = false;
		}

		if($layout == 'on'){
			$layout_status = 'iframe';
		}else{
			$layout_status = 'video';
		}

        // Configure `theme` object
        $themeObject = new \stdClass();

		if($theme_primarycolor) {
            $themeObject->primaryColor = $theme_primarycolor;
		}
        
        // Limit button type to `no selection` which is hexagon, `rectangle`, or `circle`
        $button_type = null;
        if($theme_button == 'rectangle') {
            $themeObject->button = $theme_button;
        }
        if($theme_button == 'circle') {
            $themeObject->button = $theme_button;
        }

        // Configure `plugins` object
        $pluginsObject = new \stdClass();

        // Configure `plugins->swarmads` object
		if( $ads_vasturl && $ads_vasturl !== '' ) {
            // Create the `swarmads` subobject
            $swarmadsObject = new \stdClass();
            $swarmadsObject->adTagUrl = $ads_vasturl;

            // Store the `swarmadsObject` in the `pluginsObject`
            $pluginsObject->swarmads = $swarmadsObject;
		}

        // Configure `plugins->watermark` object
		if( $watermark && $watermark !== '' ) {
            // Create the `swarmads` subobject
            $watermarkObject = new \stdClass();
            $watermarkObject->file = $watermark;
            $watermarkObject->opacity = 0.75;
            $watermarkObject->xpos = 100;
            $watermarkObject->ypos = 100;

            // Store the `watermarkObject` in the `pluginsObject`
            $pluginsObject->watermark = $watermarkObject;
		}


		if($status == true){
			$output = '
				<link rel="preconnect" href="https://assets.swarmcdn.com">
				<script data-cfasync="false">
					var swarmoptions = {
						swarmcdnkey: "'.$cdn_key.'",
						autoreplace: '.json_encode($autoreplaceObject).',
						theme: '.json_encode($themeObject).',
						plugins: '.json_encode($pluginsObject).',
						iframeReplacement: "'.$layout_status.'"
					};
				</script>
				<script data-cfasync="false" async src="https://assets.swarmcdn.com/cross/swarmdetect.js"></script>
			';
			echo $output;
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
