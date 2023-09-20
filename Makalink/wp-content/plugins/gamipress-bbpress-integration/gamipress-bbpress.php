<?php
/**
 * Plugin Name:           GamiPress - bbPress integration
 * Plugin URI:            https://wordpress.org/plugins/gamipress-bbpress-integration/
 * Description:           Connect GamiPress with bbPress.
 * Version:               1.2.7
 * Author:                GamiPress
 * Author URI:            https://gamipress.com/
 * Text Domain:           gamipress-bbpress-integration
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          6.2
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               GamiPress\bbPress
 * @author                GamiPress
 * @copyright             Copyright (c) GamiPress
 */

final class GamiPress_bbPress {

    /**
     * @var         GamiPress_bbPress $instance The one true GamiPress_bbPress
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      object self::$instance The one true GamiPress_bbPress
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_bbPress();
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->hooks();
            self::$instance->load_textdomain();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'GAMIPRESS_BBP_VER', '1.2.7' );

        // Plugin path
        define( 'GAMIPRESS_BBP_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_BBP_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            require_once GAMIPRESS_BBP_DIR . 'includes/admin.php';
            require_once GAMIPRESS_BBP_DIR . 'includes/filters.php';
            require_once GAMIPRESS_BBP_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_BBP_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_BBP_DIR . 'includes/triggers.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {
        // Setup our activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    /**
     * Activation hook for the plugin.
     */
    function activate() {

        GamiPress_bbPress::instance();

        global $wpdb;

        // Get stored version
        $stored_version = get_option( 'gamipress_bbpress_integration_version', '1.0.0' );

        if ( version_compare( $stored_version, '1.0.8', '<' ) ) {
            // GamiPress bbPress 1.0.8 upgrade

            // Setup default GamiPress options
            $gamipress_settings = ( $exists = get_option( 'gamipress_settings' ) ) ? $exists : array();

            // Initialize default settings to keep backward compatibility

            // Label on points types
            $gamipress_settings['bbp_points_types_label'] = 'on';

            // Thumbnail, thumbnail size and link on achievements
            $gamipress_settings['bbp_achievement_types_thumbnail'] = 'on';
            $gamipress_settings['bbp_achievement_types_thumbnail_size'] = '25';
            $gamipress_settings['bbp_achievement_types_link'] = 'on';

            // Title on ranks
            $gamipress_settings['bbp_rank_types_title'] = 'on';

            update_option( 'gamipress_settings', $gamipress_settings );
        }

        // Updated stored version
        update_option( 'gamipress_bbpress_integration_version', GAMIPRESS_BBP_VER );

    }

    /**
     * Deactivation hook for the plugin.
     */
    function deactivate() {

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        if ( ! $this->meets_requirements() && ! defined( 'GAMIPRESS_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'GamiPress - bbPress integration requires %s and %s in order to work. Please install and activate them.', 'gamipress-bbpress-integration' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        '<a href="https://wordpress.org/plugins/bbpress/" target="_blank">bbPress</a>'
                    ); ?>
                </p>
            </div>

            <?php define( 'GAMIPRESS_ADMIN_NOTICES', true ); ?>

        <?php endif;

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( ! class_exists( 'GamiPress' ) ) {
            return false;
        }

        // Multisite feature requires GamiPress 1.4.8
        if( is_multisite() && version_compare( GAMIPRESS_VER, '1.4.8', '>=' ) ) {

            // Requirements on multisite install
            if( gamipress_is_network_wide_active() && is_main_site() ) {

                // On main site, need to check if integrated plugin is installed on any sub site to load all configuration files
                if( gamipress_is_plugin_active_on_network( 'bbpress/bbpress.php' ) ) {
                    return true;
                }

            }

        }

        if ( ! class_exists( 'bbPress' ) ) {
            return false;
        }

        return true;

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = GAMIPRESS_BBP_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_bbpress_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-bbpress-integration' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-bbpress-integration', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-bbpress-integration/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress-bbpress-integration/ folder
            load_textdomain( 'gamipress-bbpress-integration', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress-bbpress-integration/languages/ folder
            load_textdomain( 'gamipress-bbpress-integration', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-bbpress-integration', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GamiPress_bbPress instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_bbPress The one true GamiPress_bbPress
 */
function GamiPress_bbPress() {
    return GamiPress_bbPress::instance();
}
add_action( 'plugins_loaded', 'GamiPress_bbPress' );
