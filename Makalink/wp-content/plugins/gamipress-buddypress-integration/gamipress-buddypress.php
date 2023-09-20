<?php
/**
 * Plugin Name:           GamiPress - BuddyPress integration
 * Plugin URI:            https://wordpress.org/plugins/gamipress-buddypress-integration/
 * Description:           Connect GamiPress with BuddyPress.
 * Version:               1.6.1
 * Author:                GamiPress
 * Author URI:            https://gamipress.com/
 * Text Domain:           gamipress-buddypress-integration
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          6.2
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               GamiPress\BuddyPress
 * @author                GamiPress
 * @copyright             Copyright (c) GamiPress
 */

final class GamiPress_BuddyPress {

    /**
     * @var         GamiPress_BuddyPress $instance The one true GamiPress_BuddyPress
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GamiPress_BuddyPress self::$instance The one true GamiPress_BuddyPress
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new GamiPress_BuddyPress();
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->bp_includes();
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
        define( 'GAMIPRESS_BP_VER', '1.6.1' );

        // Plugin file
        define( 'GAMIPRESS_BP_FILE', __FILE__ );

        // Plugin path
        define( 'GAMIPRESS_BP_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GAMIPRESS_BP_URL', plugin_dir_url( __FILE__ ) );
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

            require_once GAMIPRESS_BP_DIR . 'includes/admin.php';
            require_once GAMIPRESS_BP_DIR . 'includes/functions.php';
            require_once GAMIPRESS_BP_DIR . 'includes/listeners.php';
            require_once GAMIPRESS_BP_DIR . 'includes/requirements.php';
            require_once GAMIPRESS_BP_DIR . 'includes/rules-engine.php';
            require_once GAMIPRESS_BP_DIR . 'includes/scripts.php';
            require_once GAMIPRESS_BP_DIR . 'includes/triggers.php';

        }

    }

    /**
     * Include integration specific files
     *
     * @since 1.0.1
     */
    private function bp_includes() {

        // Since the multisite feature we need an extra check here to meet if BuddyPress is active on current site
        if ( $this->meets_requirements() && class_exists( 'BuddyPress' ) ) {

            require_once GAMIPRESS_BP_DIR . 'includes/components/gamipress-achievements-bp-component.php';
            require_once GAMIPRESS_BP_DIR . 'includes/components/gamipress-points-bp-component.php';
            require_once GAMIPRESS_BP_DIR . 'includes/components/gamipress-ranks-bp-component.php';

            // Profile
            require_once GAMIPRESS_BP_DIR . 'includes/bp-members.php';

            // Activity
            require_once GAMIPRESS_BP_DIR . 'includes/bp-activity.php';

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
        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }


    /**
     * Activation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function activate() {

        if ( ! class_exists( 'GamiPress' ) )
            return;

        GamiPress_BuddyPress::instance();

        global $wpdb;

        // Get stored version
        $stored_version = get_option( 'gamipress_buddypress_integration_version', '1.0.0' );

        if( gamipress_is_network_wide_active() ) {
            $gamipress_settings = get_site_option( 'gamipress_settings', array() );
        } else {
            $gamipress_settings = get_option( 'gamipress_settings', array() );
        }

        // GamiPress BuddyPress 1.0.5 upgrade
        if ( version_compare( $stored_version, '1.0.5', '<' ) ) {

            // Setup new setting
            $gamipress_settings['bp_members_achievements_types'] = array();

            $achievement_types = $wpdb->get_results( "SELECT p.ID, p.post_name FROM {$wpdb->posts} AS p WHERE p.post_type = 'achievement-type'" );

            foreach( $achievement_types as $achievement_type ) {
                $show = (bool) get_post_meta( $achievement_type->ID, '_gamipress_bp_show_bp_member_menu', true );

                if( $show ) {
                    $gamipress_settings['bp_members_achievements_types'][] = $achievement_type->post_name;
                }
            }

        }

        // GamiPress BuddyPress 1.1.8 upgrade
        if ( version_compare( $stored_version, '1.1.8', '<' ) ) {

            // Initialize default settings to keep backward compatibility

            // Label on points types
            $gamipress_settings['bp_members_points_types_top_label'] = 'on';

            // Thumbnail, thumbnail size and link on achievements
            $gamipress_settings['bp_members_achievements_top_thumbnail'] = 'on';
            $gamipress_settings['bp_members_achievements_top_thumbnail_size'] = '25';
            $gamipress_settings['bp_members_achievements_top_link'] = 'on';

            // Title on ranks
            $gamipress_settings['bp_members_ranks_top_title'] = 'on';

        }

        // GamiPress BuddyPress 1.2.6 upgrade
        if ( version_compare( $stored_version, '1.2.6', '<' ) ) {

            // Update post metas with key '_gamipress_bp_create_bp_activity' to '_gamipress_bp_create_achievement_activity'
            $wpdb->query( $wpdb->prepare(
                    "UPDATE {$wpdb->postmeta} SET meta_key = %s WHERE meta_key = %s",
                    '_gamipress_bp_create_achievement_activity',
                    '_gamipress_bp_create_bp_activity'
            ) );

        }

        // GamiPress BuddyPress 1.4.2 upgrade
        if ( version_compare( $stored_version, '1.4.2', '<' ) ) {

            // Points tab setting
            $points_placement = ( isset( $gamipress_settings['bp_points_placement'] ) ? $gamipress_settings['bp_points_placement'] : '' );

            if( in_array( $points_placement, array( 'tab', 'both' ) ) && ! isset( $gamipress_settings['bp_points_tab'] ) ) {
                $gamipress_settings['bp_points_tab'] = 'on';
            }

            // Achievements tab setting
            $achievements_placement = ( isset( $gamipress_settings['bp_achievements_placement'] ) ? $gamipress_settings['bp_achievements_placement'] : '' );

            if( in_array( $achievements_placement, array( 'tab', 'both' ) ) && ! isset( $gamipress_settings['bp_achievements_tab'] ) ) {
                $gamipress_settings['bp_achievements_tab'] = 'on';
            }


            // Ranks tab setting
            $ranks_placement = ( isset( $gamipress_settings['bp_ranks_placement'] ) ? $gamipress_settings['bp_ranks_placement'] : '' );

            if( in_array( $ranks_placement, array( 'tab', 'both' ) ) && ! isset( $gamipress_settings['bp_ranks_tab'] ) ) {
                $gamipress_settings['bp_ranks_tab'] = 'on';
            }

            // Clone types and order settings
            foreach( array( 'points', 'achievements', 'ranks' ) as $key ) {
                if( ! isset( $gamipress_settings["bp_tab_{$key}_types"] ) ) {
                    $gamipress_settings["bp_tab_{$key}_types"] = $gamipress_settings["bp_members_{$key}_types"];
                    $gamipress_settings["bp_tab_{$key}_types_order"] = $gamipress_settings["bp_members_{$key}_types_order"];
                }
            }

            // Finally, update placement to the new options
            if( ! is_array( $gamipress_settings['bp_points_placement'] ) && in_array( $gamipress_settings['bp_points_placement'], array( 'top', 'both' ) ) ) {
                $gamipress_settings['bp_points_placement'] = array( 'top' );
            } else {
                $gamipress_settings['bp_points_placement'] = array();
            }

            if( ! is_array( $gamipress_settings['bp_achievements_placement'] ) && in_array( $gamipress_settings['bp_achievements_placement'], array( 'top', 'both' ) ) ) {
                $gamipress_settings['bp_achievements_placement'] = array( 'top' );
            } else {
                $gamipress_settings['bp_achievements_placement'] = array();
            }

            if( ! is_array( $gamipress_settings['bp_ranks_placement'] ) && in_array( $gamipress_settings['bp_ranks_placement'], array( 'top', 'both' ) ) ) {
                $gamipress_settings['bp_ranks_placement'] = array( 'top' );
            } else {
                $gamipress_settings['bp_ranks_placement'] = array();
            }

        }

        // Update GamiPress options
        if( gamipress_is_network_wide_active() ) {
            update_site_option( 'gamipress_settings', $gamipress_settings );
        } else {
            update_option( 'gamipress_settings', $gamipress_settings );
        }

        // Updated stored version
        update_option( 'gamipress_buddypress_integration_version', GAMIPRESS_BP_VER );

    }

    /**
     * Deactivation hook for the plugin.
     *
     * @since  1.0.0
     */
    public static function deactivate() {

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
                        __( 'GamiPress - BuddyPress integration requires %s and %s in order to work. Please install and activate them.', 'gamipress-buddypress-integration' ),
                        '<a href="https://wordpress.org/plugins/gamipress/" target="_blank">GamiPress</a>',
                        '<a href="https://wordpress.org/plugins/buddypress/" target="_blank">BuddyPress</a>'
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

        // Requirements on multisite install
        if( is_multisite() && gamipress_is_network_wide_active() && is_main_site() ) {
            // On main site, need to check if integrated plugin is installed on any sub site to load all configuration files
            if( gamipress_is_plugin_active_on_network( 'buddypress/bp-loader.php' ) )
                return true;
        }

        if ( ! class_exists( 'BuddyPress' ) ) {
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
        $lang_dir = GAMIPRESS_BP_DIR . '/languages/';
        $lang_dir = apply_filters( 'gamipress_buddypress_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress-buddypress-integration' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'gamipress-buddypress-integration', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/gamipress-buddypress-integration/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress-buddypress-integration/ folder
            load_textdomain( 'gamipress-buddypress-integration', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress-buddypress-integration/languages/ folder
            load_textdomain( 'gamipress-buddypress-integration', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'gamipress-buddypress-integration', false, $lang_dir );
        }
    }

}

/**
 * The main function responsible for returning the one true GamiPress_BuddyPress instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress_BuddyPress The one true GamiPress_BuddyPress
 */
function GamiPress_BP() {
    return GamiPress_BuddyPress::instance();
}
add_action( 'plugins_loaded', 'GamiPress_BP' );

// Setup our activation and deactivation hooks
register_activation_hook( __FILE__, array( 'GamiPress_BuddyPress', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'GamiPress_BuddyPress', 'deactivate' ) );
