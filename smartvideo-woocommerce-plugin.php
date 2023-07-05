<?php
/**
 * Plugin Name: SmartVideo
 * Version: 0.1.0
 * Author: Matthew Davidson
 * Author URI: https://modulolotus.net
 * Text Domain: smartvideo-woocommerce-plugin
 * Domain Path: /languages
 *
 * License: GNU Affero General Public License v3.0
 * License URI: https://www.gnu.org/licenses/agpl-3.0.en.html
 *
 * @package extension
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MAIN_PLUGIN_FILE' ) ) {
	define( 'MAIN_PLUGIN_FILE', __FILE__ );
}

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';

use SmartvideoWoocommercePlugin\Admin\Setup;

// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 0.1.0
 */
function smartvideo_woocommerce_plugin_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'SmartVideo requires WooCommerce to be installed and active. You can download %s here.', 'smartvideo_woocommerce_plugin' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

register_activation_hook( __FILE__, 'smartvideo_woocommerce_plugin_activate' );

/**
 * Activation hook.
 *
 * @since 0.1.0
 */
function smartvideo_woocommerce_plugin_activate() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'smartvideo_woocommerce_plugin_missing_wc_notice' );
		return;
	}
}

if ( ! class_exists( 'smartvideo_woocommerce_plugin' ) ) :
	/**
	 * The smartvideo_woocommerce_plugin class.
	 */
	class smartvideo_woocommerce_plugin {
		/**
		 * This class instance.
		 *
		 * @var \smartvideo_woocommerce_plugin single instance of this class.
		 */
		private static $instance;

		/**
		 * Constructor.
		 */
		public function __construct() {
			if ( is_admin() ) {
				new Setup();
			}
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'smartvideo_woocommerce_plugin' ), $this->version );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'smartvideo_woocommerce_plugin' ), $this->version );
		}

		/**
		 * Gets the main instance.
		 *
		 * Ensures only one instance can be loaded.
		 *
		 * @return \smartvideo_woocommerce_plugin
		 */
		public static function instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
endif;

add_action( 'plugins_loaded', 'smartvideo_woocommerce_plugin_init', 10 );

/**
 * Initialize the plugin.
 *
 * @since 0.1.0
 */
function smartvideo_woocommerce_plugin_init() {
	load_plugin_textdomain( 'smartvideo_woocommerce_plugin', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'smartvideo_woocommerce_plugin_missing_wc_notice' );
		return;
	}

	smartvideo_woocommerce_plugin::instance();

}
