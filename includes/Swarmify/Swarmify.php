<?php

namespace SmartvideoForWoocommerce\Swarmify;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=48
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
	protected $log;

	protected $option_list = array(
		'swarmify_cdn_key',
		'swarmify_status',
		'swarmify_toggle_youtube',
		'swarmify_toggle_youtube_cc',
		'swarmify_toggle_layout',
		'swarmify_toggle_bgvideo',
		'swarmify_theme_button',
		'swarmify_toggle_uploadacceleration',
		'swarmify_theme_primarycolor',
		'swarmify_watermark',
		'swarmify_ads_vasturl'
	);

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_name) {
		if ( defined( 'SWARMIFY_PLUGIN_VERSION' ) ) {
			$this->version = SWARMIFY_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = $plugin_name;
		$this->log = new \WC_Logger();

		$this->log_debug_info();

		// enable upload accelerator
		$swarmify_upload_accelerator = UploadAccelerator::get_instance();

		$this->load_dependencies();
        $this->load_config_from_constants();

		if ( is_admin() ) {
			$this->define_admin_hooks();
		}

		$this->set_locale();
		$this->define_public_hooks();

		add_shortcode( 'smartvideo', array($this,'smartvideo_shortcode') );

    }


    public function smartvideo_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'src' => '',
			'poster'=>'',
			'height' => '',
			'width' => '',
			'responsive'=> '',
			'autoplay' => '',
			'muted'=> '',
			'loop'=> '',
			'controls' => '',
			'playsinline' => '',
		), $atts, 'smartvideo' );
		$swarmify_url = $atts['src'];
		$poster = ($atts['poster'] === '' ? '' : 'poster="'.$atts['poster'].'"');
		$height = ($atts['height'] !== '' ? $atts['height'] : '');
		$width = ($atts['width'] !== '' ? $atts['width'] : '');
    	$autoplay = ($atts['autoplay'] === 'true' ? 'autoplay' : '');
    	$muted = ($atts['muted'] === 'true' ? 'muted' : '');
    	$loop = ($atts['loop'] === 'true' ? 'loop' : '');
    	$controls = ($atts['controls'] === 'true' ? 'controls' : '');
    	$video_inline = ($atts['playsinline'] === 'true' ? 'playsinline' : '');
    	$unresponsive = ($atts['responsive'] === 'true' ? 'class="swarm-fluid"' : '' );

    	return '<smartvideo src="'.$swarmify_url.'" width="'.$width.'" height="'.$height.'" '.$unresponsive.' '.$poster.' '.$autoplay.' '.$muted.' '.$loop.' '.$controls.' '.$video_inline.'></smartvideo>';
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
		//  * The class responsible for activating the UploadAccelerator.
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
		$admin = new Admin($this->plugin_name, $this->version);

		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_classic_editor_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_classic_editor_scripts' );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'register_scripts' );
        $this->loader->add_action( 'admin_menu', $admin, 'register_page' );

		$this->loader->add_action( 'widgets_init', $admin, 'load_widget' );

		$this->loader->add_action( 'media_buttons', $admin, 'add_video_button', 15);
		$this->loader->add_action( 'admin_footer',  $admin, 'add_video_lightbox_html');


		$this->loader->add_filter( 'plugin_action_links_' . plugin_basename( SMARTVIDEO_FOR_WC_PLUGIN_FILE ), $admin, 'plugin_action_links' );

		// Can't load shortcode here, needed for front-end. Old plugin called this fn even when not admin
	}

	public function add_option_permissions( $permissions ) {
		foreach ($this->option_list as $value) {
			$permissions[ $value ] = current_user_can( 'manage_options' );
		}
	

		return $permissions;
	}
	
	

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$this->loader->add_action('wp_head', $this, 'swarmify_script');
		$this->loader->add_action('admin_head', $this, 'swarmify_script');

		add_filter( 'woocommerce_rest_api_option_permissions', array( $this, 'add_option_permissions' ), 10, 1 );

	}

	/**
	 * Echo the swarmdetect settings and script
	 */
	public function swarmify_script(){
		$cdn_key = get_option('swarmify_cdn_key');
		$swarmify_status = get_option('swarmify_status');
        $youtube = get_option('swarmify_toggle_youtube');
        $youtube_cc = get_option('swarmify_toggle_youtube_cc');
		$layout = get_option('swarmify_toggle_layout');
		$bgoptimize = get_option('swarmify_toggle_bgvideo');
		$theme_primarycolor = get_option('swarmify_theme_primarycolor', '#ffde17');
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
            // $watermarkObject->file = $watermark;
			$watermarkObject->file = $watermark['url'];
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
	public function log_debug_info() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		$this->log->debug( var_export( [
			'this->plugin_name' => $this->plugin_name,
			'plugin_basename' => plugin_basename( SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
			'plugin_dir_path' => plugin_dir_path( SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
			'dirname(plugin_dir_path())' => dirname(plugin_dir_path( SMARTVIDEO_FOR_WC_PLUGIN_FILE )),
			'dirname(plugin_basename())' => dirname(plugin_basename( SMARTVIDEO_FOR_WC_PLUGIN_FILE )),
			'plugin_basename(dirname())' => plugin_basename(dirname( SMARTVIDEO_FOR_WC_PLUGIN_FILE )),
			'plugin_dir_url' => plugin_dir_url( SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
			'WC_ABSPATH' => WC_ABSPATH,
			'WC_PLUGIN_BASENAME' => WC_PLUGIN_BASENAME,
			'WC_PLUGIN_FILE' => WC_PLUGIN_FILE,
			'WC_VERSION' => WC_VERSION,
			// 'get_plugins' => get_plugins(),
		], true ));	
	}

}
