<?php
/**
 * Plugin Name: SmartVideo
 * Version: 0.1.0
 * Author: Matthew Davidson
 * Author URI: https://modulolotus.net
 * Text Domain: SmartVideo_WooCommerce_Plugin
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
function SmartVideo_WooCommerce_Plugin_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'SmartVideo requires WooCommerce to be installed and active. You can download %s here.', 'SmartVideo_WooCommerce_Plugin' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

register_activation_hook( __FILE__, 'SmartVideo_WooCommerce_Plugin_activate' );

/**
 * Activation hook.
 *
 * @since 0.1.0
 */
function SmartVideo_WooCommerce_Plugin_activate() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'SmartVideo_WooCommerce_Plugin_missing_wc_notice' );
		return;
	}
}

if ( ! class_exists( 'SmartVideo_WooCommerce_Plugin' ) ) :
	/**
	 * The SmartVideo_WooCommerce_Plugin class.
	 */
	class SmartVideo_WooCommerce_Plugin {
		/**
		 * This class instance.
		 *
		 * @var \SmartVideo_WooCommerce_Plugin single instance of this class.
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
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'SmartVideo_WooCommerce_Plugin' ), $this->version );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'SmartVideo_WooCommerce_Plugin' ), $this->version );
		}

		/**
		 * Gets the main instance.
		 *
		 * Ensures only one instance can be loaded.
		 *
		 * @return \SmartVideo_WooCommerce_Plugin
		 */
		public static function instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
endif;

add_action( 'plugins_loaded', 'SmartVideo_WooCommerce_Plugin_init', 10 );

/**
 * Initialize the plugin.
 *
 * @since 0.1.0
 */
function SmartVideo_WooCommerce_Plugin_init() {
	load_plugin_textdomain( 'SmartVideo_WooCommerce_Plugin', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'SmartVideo_WooCommerce_Plugin_missing_wc_notice' );
		return;
	}

	SmartVideo_WooCommerce_Plugin::instance();

}
