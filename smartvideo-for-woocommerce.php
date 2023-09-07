<?php
/**
 * Plugin Name: SmartVideo for WooCommerce
 * Description: Video player and unlimited video hosting built to work for WooCommerce users
 * Version: 2.1.0
 * Requires at least: 3.0.1
 * Requires PHP: 7.3
 * Author: Matthew Davidson
 * Author URI: https://swarmify.com
 * Developer: Matthew Davidson
 * Developer URI: https://swarmify.com/
 * Text Domain: smartvideo-for-woocommerce
 * Domain Path: /languages
 *
 * Woo:
 * WC requires at least: 6.5
 * WC tested up to: 8.0.3
 *
 * License: GNU Affero General Public License v3.0
 * License URI: https://www.gnu.org/licenses/agpl-3.0.en.html
 *
 * @package Swarmify
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SMARTVIDEO_FOR_WC_PLUGIN_FILE' ) ) {
	define( 'SMARTVIDEO_FOR_WC_PLUGIN_FILE', __FILE__ );
}

define( 'SWARMIFY_PLUGIN_VERSION', '2.1.0' );

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';

use SmartvideoForWoocommerce\Swarmify as Swarmify;


// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 2.1.0
 */
if ( ! function_exists( 'SmartVideo_For_WooCommerce_missing_wc_notice' ) ) {
	function SmartVideo_For_WooCommerce_missing_wc_notice() {
		echo '<div class="error"><p><strong>'
			. sprintf(
				/* translators: %s WC download URL link. */
				esc_html__( 'This version of SmartVideo requires WooCommerce to be installed and active. You can download WooCommerce %s.', 'smartvideo-for-woocommerce' )
				. '</strong></p></p><strong>'
				/* translators: %s SmartVideo download URL link. */
				. esc_html__( 'If you are NOT using WooCommerce, you want the general SmartVideo plugin for WordPress, available %s. (Make sure to uninstall the Woo-specific version before installing the general version.)', 'smartvideo-for-woocommerce' ),
				'<a href="https://woocommerce.com/" target="_blank">here</a>',
				'<a href="https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=52" target="_blank">here</a>'
			)
			. '</strong></p></div>';
	}
}


if ( ! function_exists( 'activate_smartvideo_for_woocommerce' ) ) {
	function activate_smartvideo_for_woocommerce() {
		Swarmify\Activator::activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 */
if ( ! function_exists( 'deactivate_smartvideo_for_woocommerce' ) ) {
	function deactivate_smartvideo_for_woocommerce() {
		Swarmify\Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_smartvideo_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_smartvideo_for_woocommerce' );


if ( ! class_exists( 'SmartVideo_For_WooCommerce' ) ) {
	/**
	 * The SmartVideo_For_WooCommerce class.
	 */
	class SmartVideo_For_WooCommerce {
		/**
		 * This class instance.
		 *
		 * @var \SmartVideo_For_WooCommerce single instance of this class.
		 */
		private static $instance;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$plugin_name = dirname( plugin_basename( SMARTVIDEO_FOR_WC_PLUGIN_FILE ) );
			$plugin      = new Swarmify\Swarmify( $plugin_name );
			$plugin->run();
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'smartvideo-for-woocommerce' ), $this->version );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'smartvideo-for-woocommerce' ), $this->version );
		}

		/**
		 * Gets the main instance.
		 *
		 * Ensures only one instance can be loaded.
		 *
		 * @return \SmartVideo_For_WooCommerce
		 */
		public static function instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}


/**
 *  Load page builders
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/page-builders/elementor/class-elementor-swarmify.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/page-builders/gutenberg/src/init.php';

if ( ! function_exists( 'smartvideo_load_beaver_builder' ) ) {
	function smartvideo_load_beaver_builder() {
		if ( class_exists( 'FLBuilder' ) ) {
			require plugin_dir_path( __FILE__ ) . 'includes/page-builders/beaverbuilder/class-beaverbuilder-smartvideo.php';
		}
	}
	add_action( 'init', 'smartvideo_load_beaver_builder' );
}

if ( ! function_exists( 'smartvideo_load_divi_builder' ) ) {
	function smartvideo_load_divi_builder() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/page-builders/divi-builder/includes/DiviBuilder.php';
	}

	add_action( 'divi_extensions_init', 'smartvideo_load_divi_builder' );
}



/**
 * Initialize the plugin.
 *
 * @since 2.1.0
 */
function SmartVideo_For_WooCommerce_init() {
	load_plugin_textdomain( 'smartvideo-for-woocommerce', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'SmartVideo_For_WooCommerce_missing_wc_notice' );
		return;
	}

	SmartVideo_For_WooCommerce::instance();

}

add_action( 'plugins_loaded', 'SmartVideo_For_WooCommerce_init', 10 );
