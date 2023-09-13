<?php

namespace SmartvideoForWoocommerce\Swarmify;

/**
 * SmartvideoForWoocommerce Admin Class
 */
class Admin {
	protected $plugin_name;
	protected $version;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Load all necessary dependencies.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		if ( ! method_exists( 'Automattic\WooCommerce\Admin\PageController', 'is_admin_or_embed_page' ) ||
		! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page()
		) {
			return;
		}

		$script_path       = '/build/index.js';
		$script_asset_path = dirname( SMARTVIDEO_FOR_WC_PLUGIN_FILE ) . '/build/index.asset.php';
		$script_asset      = file_exists( $script_asset_path )
			? require $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => $this->version,
			);
		$script_url        = plugins_url( $script_path, SMARTVIDEO_FOR_WC_PLUGIN_FILE );

		wp_register_script(
			'smartvideo-for-woocommerce',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_register_style(
			'smartvideo-for-woocommerce',
			plugins_url( '/build/index.css', SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
			// Add any dependencies styles may have, such as wp-components.
			array( 'wp-components' ),
			'2.1.0'
		);

		wp_enqueue_script( 'smartvideo-for-woocommerce' );
		wp_enqueue_style( 'smartvideo-for-woocommerce' );

		wp_localize_script(
			'smartvideo-for-woocommerce',
			'smartvideoPlugin',
			array(
				'baseUrl'    => plugins_url( '', SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
				'assetUrl'   => plugins_url( '/assets', SMARTVIDEO_FOR_WC_PLUGIN_FILE ),
				'version'    => $this->version,
				'textDomain' => 'smartvideo-for-woocommerce',
			)
		);
	}

	/**
	 * Register page in wc-admin.
	 *
	 * @since 1.0.0
	 */
	public function register_page() {

		if ( ! function_exists( 'wc_admin_register_page' ) ) {
			return;
		}

		// base64-encoded from assets/icon.svg, but modified for the menu
		$menu_icon = <<<EOSVG
        <svg viewBox="0 0 47 47" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" version="1.1" width="47" height="47" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
            <path fill="#000" d="M 23.050781,0 23.044922,0.00390625 23.039062,0 Z m 20.988281,11.519531 v 23.041016 l -21,11.519531 L 2.0390625,34.560547 V 11.519531 L 23.044922,0.00390625 Z m -28.519531,1.910157 v 19.390624 c 0,1.999998 1.319689,2.869687 2.929688,1.929688 L 35.5,24.820312 c 1.619998,-0.939999 1.619998,-2.460391 0,-3.40039 L 18.449219,11.5 c -0.4025,-0.2375 -0.786563,-0.362188 -1.136719,-0.382812 -1.050468,-0.06188 -1.792969,0.805001 -1.792969,2.3125 z" />
        </svg>
EOSVG;

		wc_admin_register_page(
			array(
				'id'         => 'SmartVideo-admin',
				'title'      => __( 'SmartVideo', 'smartvideo-for-woocommerce' ),
				// 'parent' => 'woocommerce',
				'capability' => 'manage_woocommerce',
				'icon'       => 'data:image/svg+xml;base64,' . base64_encode( $menu_icon ),
				// 'icon' => 'dashicons-video-alt3',
				// 'icon' => plugins_url('/assets/icon.svg', SMARTVIDEO_FOR_WC_PLUGIN_FILE),
				'position'   => 63, // see https://developer.wordpress.org/reference/functions/add_menu_page/#default-bottom-of-menu-structure
				'path'       => '/smartvideo-for-woocommerce',
			)
		);
	}

	public function enqueue_classic_editor_styles() {
		wp_enqueue_style( $this->plugin_name . '-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . '-fancybox', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox.min.css', array(), $this->version, 'all' );

		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style( $this->plugin_name . '-swarmify-admin', plugin_dir_url( __FILE__ ) . 'css/swarmify-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_classic_editor_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Swarmify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Swarmify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-mask', plugin_dir_url( __FILE__ ) . 'js/jquery.inputmask.bundle.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name . '-fancybox', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name . '-swarmify-admin', plugin_dir_url( __FILE__ ) . 'js/swarmify-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );

		/** Only loaded on our admin pages */
		if ( 'toplevel_page_' != $hook ) {
			wp_enqueue_script( $this->plugin_name . '-mt', plugin_dir_url( __FILE__ ) . 'js/mt.js', array(), $this->version, false );
		}

	}

	/**
	 * Show Settings link on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-admin&path=/smartvideo-for-woocommerce' ) . '" aria-label="' . esc_attr__( 'View SmartVideo settings', 'smartvideo-for-woocommerce' ) . '">' . esc_html__( 'Settings', 'smartvideo-for-woocommerce' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}


	/**
	 * Register options/settings.
	 *
	 * @since 2.1.0
	 */

	public function register_settings() {

	}

	public function add_video_button() {
		echo '<a href="" data-fancybox data-src="#swarmify-modal-content" class="button swarmify_add_button"><img src="' . esc_attr( plugin_dir_url( __FILE__ )) . 'images/smartvideo_icon.png" alt="">Add SmartVideo</a>';
	}

	public function add_video_lightbox_html() {
		require 'partials/add-video-lightbox-display.php';
	}
}
