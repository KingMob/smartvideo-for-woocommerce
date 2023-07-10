<?php

namespace SmartvideoWoocommercePlugin\Admin;

/**
 * SmartvideoWoocommercePlugin Setup Class
 */
class Setup {
    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
        add_action( 'admin_menu', array( $this, 'register_page' ) );
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
        $script_asset_path = dirname( MAIN_PLUGIN_FILE ) . '/build/index.asset.php';
        $script_asset      = file_exists( $script_asset_path )
        ? require $script_asset_path
        : array(
            'dependencies' => array(),
            'version'      => filemtime( $script_path ),
        );
        $script_url        = plugins_url( $script_path, MAIN_PLUGIN_FILE );

        wp_register_script(
            'smartvideo-woocommerce-plugin',
            $script_url,
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );

        wp_register_style(
            'smartvideo-woocommerce-plugin',
            plugins_url( '/build/index.css', MAIN_PLUGIN_FILE ),
            // Add any dependencies styles may have, such as wp-components.
            array(),
            filemtime( dirname( MAIN_PLUGIN_FILE ) . '/build/index.css' )
        );

        wp_enqueue_script( 'smartvideo-woocommerce-plugin' );
        wp_enqueue_style( 'smartvideo-woocommerce-plugin' );
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
                'id'     => 'SmartVideo-admin',
                'title'  => __( 'SmartVideo', 'swarmify' ),
                // 'parent' => 'woocommerce',
                'capability' => 'manage_woocommerce',
                'icon' => 'data:image/svg+xml;base64,' . base64_encode($menu_icon),
                // 'icon' => 'dashicons-video-alt3',
                // 'icon' => plugins_url('/assets/icon.svg', MAIN_PLUGIN_FILE),
                'position' => 63, // see https://developer.wordpress.org/reference/functions/add_menu_page/#default-bottom-of-menu-structure
                'path'   => '/smartvideo-woocommerce-plugin',
            )
        );
    }
}
