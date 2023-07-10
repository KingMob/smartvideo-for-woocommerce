<?php
/**
 * Plugin Name: SmartVideo
 * Version: 2.1.0
 * Author: Matthew Davidson
 * Author URI: https://modulolotus.net
 * Text Domain: swarmify
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

use SmartvideoWoocommercePlugin\Swarmify as Swarmify;

define( 'SWARMIFY_PLUGIN_VERSION', '2.1.0' );

// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 2.1.0
 */
function SmartVideo_WooCommerce_Plugin_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'SmartVideo requires WooCommerce to be installed and active. You can download %s here.', 'SmartVideo_WooCommerce_Plugin' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}


function activate_swarmify() {
	Swarmify\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-swarmify-deactivator.php
 */
function deactivate_swarmify() {
	Swarmify\Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_swarmify' );
register_deactivation_hook( __FILE__, 'deactivate_swarmify' );


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
		
			// add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

			$plugin = new Swarmify\Swarmify();
			$plugin->run();
		
		}

		// public function register_scripts() {
		// 	wp_enqueue_script(
		// 		'smartvideo-woocommerce-plugin',
		// 		plugins_url( '/build/index.js', MAIN_PLUGIN_FILE ),
		// 		array( 'jquery' ),
		// 		filemtime( dirname( MAIN_PLUGIN_FILE ) . '/build/index.js' ),
		// 		true
		// 	);
		// }

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

/**
 * Initialize the plugin.
 *
 * @since 2.1.0
 */
function SmartVideo_WooCommerce_Plugin_init() {
	load_plugin_textdomain( 'swarmify', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'SmartVideo_WooCommerce_Plugin_missing_wc_notice' );
		return;
	}

	SmartVideo_WooCommerce_Plugin::instance();

}

add_action( 'plugins_loaded', 'SmartVideo_WooCommerce_Plugin_init', 10 );
