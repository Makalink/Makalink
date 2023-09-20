<?php
/**
 * Functions - Backend - Plugin
 * 
 * @package Vikinger
 * 
 * @since 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!class_exists('Vikinger_Installer')) {
  /**
   * Plugin installer.
   * 
   * @since 1.0.0
   */
  class Vikinger_Installer {
    private $plugins;

    /**
     * Constructor function.
     * 
     * @since 1.0.0
     */
    public function __construct() {
      $plugins = [
        /**
         * WordPress
         */
        'buddypress'                        => [
          'name'  => 'BuddyPress',
          'slug'  => 'buddypress/bp-loader.php',
          'type'  => 'wordpress'
        ],
        'bp-verified-member'                => [
          'name'  => 'Verified Member for BuddyPress',
          'type'  => 'wordpress'
        ],
        'bp-better-messages'                => [
          'name'  => 'Better Messages',
          'type'  => 'wordpress'
        ],
        'bbpress'                           => [
          'name'  => 'bbPress',
          'type'  => 'wordpress'
        ],
        'gamipress'                         => [
          'name'  => 'GamiPress',
          'type'  => 'wordpress'
        ],
        'gamipress-buddypress-integration'  => [
          'name'  => 'GamiPress - BuddyPress Integration',
          'slug'  => 'gamipress-buddypress-integration/gamipress-buddypress.php',
          'type'  => 'wordpress'
        ],
        'gamipress-bbpress-integration'     => [
          'name'  => 'GamiPress - bbPress Integration',
          'slug'  => 'gamipress-bbpress-integration/gamipress-bbpress.php',
          'type'  => 'wordpress'
        ],
        'woocommerce'                       => [
          'name'  => 'WooCommerce',
          'type'  => 'wordpress'
        ],
        'elementor'                         => [
          'name'  => 'Elementor',
          'type'  => 'wordpress'
        ],
        'paid-memberships-pro'              => [
          'name'  => 'Paid Memberships Pro',
          'type'  => 'wordpress'
        ],
        'pmpro-buddypress'                  => [
          'name'  => 'Paid Memberships Pro - BuddyPress Add On',
          'type'  => 'wordpress'
        ],
        'pmpro-bbpress'                     => [
          'name'  => 'Paid Memberships Pro - bbPress Add On',
          'type'  => 'wordpress'
        ],
        'advanced-ads'                      => [
          'name'  => 'Advanced Ads',
          'type'  => 'wordpress'
        ],
        /**
         * Local
         */
        'vikinger-buddypress-extension' => [
          'name'            => 'Vikinger - BuddyPress Extension',
          'type'            => 'local',
          'latest_version'  => '1.1.1'
        ],
        'vkreact'                       => [
          'name'            => 'Vikinger Reactions',
          'type'            => 'local',
          'latest_version'  => '1.0.4'
        ],
        'vkreact-buddypress'            => [
          'name'            => 'Vikinger Reactions - BuddyPress Integration',
          'type'            => 'local',
          'latest_version'  => '1.0.4'
        ],
        'vkmedia'                       => [
          'name'            => 'Vikinger Media',
          'type'            => 'local',
          'latest_version'  => '1.0.0'
        ],
        'vikinger-widgets'              => [
          'name'            => 'Vikinger Widgets',
          'type'            => 'local',
          'latest_version'  => '1.0.0'
        ],
        'vikinger-metaboxes'            => [
          'name'            => 'Vikinger Metaboxes',
          'type'            => 'local',
          'latest_version'  => '1.0.2'
        ]
      ];

      $this->plugins = [];

      foreach ($plugins as $plugin_id => $plugin_data) {
        $this->plugins[$plugin_id] = $plugin_data;

        if (!array_key_exists('slug', $plugin_data)) {
          $this->plugins[$plugin_id]['slug'] = $this->getDefaultPluginSlug($plugin_id);
        }

        if (!array_key_exists('url', $plugin_data)) {
          if ($plugin_data['type'] === 'wordpress') {
            $this->plugins[$plugin_id]['url'] = $this->getWordPressPluginDownloadLink($plugin_id);
          }
        }

        if (!array_key_exists('path', $plugin_data)) {
          if ($plugin_data['type'] === 'local') {
            $this->plugins[$plugin_id]['path'] = $this->getDefaultPluginPath($plugin_id);
          }
        }
      }
    }

    /**
     * Returns default plugin slug.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id          ID of the plugin.
     * @return string $plugin_slug        Plugin slug.
     */
    private function getDefaultPluginSlug($plugin_id) {
      $plugin_slug = $plugin_id . '/' . $plugin_id . '.php';

      return $plugin_slug;
    }

    /**
     * Returns default plugin path.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id           ID of the plugin.
     * @return string $plugin_path        Plugin path.
     */
    private function getDefaultPluginPath($plugin_id) {
      $plugin_path = VIKINGER_PATH . '/backend/plugin/' . $plugin_id . '.zip';

      return $plugin_path;
    }

    /**
     * Returns plugin parameter.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id                 ID of the plugin.
     * @param string $parameter                 Plugin parameter to retrieve.
     * @return string|bool $plugin_parameter         Plugin parameter, or false if plugin doesn't exist.
     */
    private function getPluginParameter($plugin_id, $parameter) {
      $plugin_parameter = false;

      if (array_key_exists($plugin_id, $this->plugins)) {
        if (array_key_exists($parameter, $this->plugins[$plugin_id])) {
          $plugin_parameter = $this->plugins[$plugin_id][$parameter];
        }
      }

      return $plugin_parameter;
    }

    /**
     * Returns WordPress plugin download link.
     * 
     * @since 1.0.0
     * 
     * @param string  $plugin_id          ID of the plugin.
     * @return string $download_link      Plugin zip file download link.
     */
    private function getWordPressPluginDownloadLink($plugin_id) {
      $download_link = 'https://downloads.wordpress.org/plugin/' . $plugin_id . '.latest-stable.zip';

      return $download_link;
    }

    /**
     * Returns plugin latest version from repository.
     * 
     * @since 1.0.0
     * 
     * @param string  $plugin_id                  ID of the plugin.
     * @return string|bool $latest_version        Plugin repository latest version or false on error.
     */
    private function getWordPressPluginLatestVersion($plugin_id) {
      $latest_version = false;

      $url = 'https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[slugs][]=' . $plugin_id;

      $response = wp_remote_get($url);

      if (!is_wp_error($response)) {
        $plugin_data = json_decode($response['body'], true);
  
        if (array_key_exists($plugin_id, $plugin_data) && array_key_exists('version', $plugin_data[$plugin_id])) {
          $latest_version = $plugin_data[$plugin_id]['version'];
        }
      }

      return $latest_version;
    }

    /**
     * Returns whether a plugin is installed.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id         ID of the plugin.
     * @return bool $is_installed       True if plugin is installed, false otherwise.
     */
    private function isPluginInstalled($plugin_id) {
      $is_installed = (bool) $this->getInstalledPluginData($plugin_id);

      return $is_installed;
    }

    /**
     * Returns installed plugin data.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id                         ID of the plugin.
     * @return array|bool $installed_plugin_data        Plugin data or false on error.
     */
    private function getInstalledPluginData($plugin_id) {
      $installed_plugin_data = false;

      $plugin_data = array_key_exists($plugin_id, $this->plugins) ? $this->plugins[$plugin_id] : false;

      if ($plugin_data) {
        $plugin_slug = array_key_exists('slug', $plugin_data) ? $plugin_data['slug'] : false;

        if ($plugin_slug) {
          $wp_installed_plugins = get_plugins();

          $installed_plugin_data = array_key_exists($plugin_slug, $wp_installed_plugins) ? $wp_installed_plugins[$plugin_slug] : false;
        }
      }

      return $installed_plugin_data;
    }

    /**
     * Returns whether a plugin is active.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id         ID of the plugin.
     * @return bool $is_active          True if plugin is active, false otherwise.
     */
    private function isPluginActive($plugin_id) {
      $is_active = false;

      switch ($plugin_id) {
        case 'buddypress':
          $is_active = function_exists('buddypress');
          break;

        case 'bp-verified-member':
          $is_active = class_exists('BP_Verified_Member');
          break;

        case 'bbpress':
          $is_active = class_exists('bbPress');
          break;

        case 'bp-better-messages':
          $is_active = class_exists('BP_Better_Messages');
          break;

        case 'bp-verified-member':
          $is_active = class_exists('BP_Verified_Member');
          break;

        case 'gamipress':
          $is_active = function_exists('GamiPress');
          break;

        case 'gamipress-buddypress-integration':
          $is_active = class_exists('GamiPress_BuddyPress');
          break;

        case 'gamipress-bbpress-integration':
          $is_active = class_exists('GamiPress_bbPress');
          break;

        case 'woocommerce':
          $is_active = class_exists('WooCommerce');
          break;

        case 'paid-memberships-pro':
          $is_active = function_exists('pmpro_init');
          break;

        case 'pmpro-buddypress':
          $is_active = function_exists('pmpro_bp_get_level_options');
          break;

        case 'pmpro-bbpress':
          $is_active = function_exists('pmprobb_init');
          break;

        case 'advanced-ads':
          $is_active = class_exists('Advanced_Ads');
          break;

        case 'advanced-ads-pro':
          $is_active = class_exists('Advanced_Ads_Pro');
          break;

        case 'elementor':
          $is_active = class_exists('Elementor\Plugin');
          break;

        case 'vikinger-buddypress-extension':
          $is_active = function_exists('vikinger_buddypress_extension_init');
          break;

        case 'vkreact':
          $is_active = function_exists('vkreact_activate');
          break;

        case 'vkreact-buddypress':
          $is_active = function_exists('vkreact_bp_activate');
          break;

        case 'vkmedia':
          $is_active = function_exists('vkmedia_activate');
          break;

        case 'vikinger-widgets':
          $is_active = function_exists('vkwidgets_activate');
          break;

        case 'vikinger-metaboxes':
          $is_active = function_exists('vkmetaboxes_activate');
          break;
      }

      return $is_active;
    }

    /**
     * Runs a method.
     * 
     * @since 1.0.0
     * 
     * @param string $method_name     Name of the method to run.
     * @param array $method_args      Arguments of the method to run.
     * @return mixed|null $result     Method result or NULL if method doesn't exist.
     */
    private function runMethod($method_name, $method_args = NULL) {
      $result = NULL;

      if (method_exists($this, $method_name)) {
        if (!is_null($method_args)) {
          $result = $this->{$method_name}(...$method_args);
        } else {
          $result = $this->{$method_name}();
        }
      }

      return $result;
    }

    /**
     * Runs a process at least retries times on failure.
     * 
     * @since 1.0.0
     * 
     * @param string $method_name       Name of the method to run.
     * @param array $method_args       Arguments of the process to run.
     * @param int $retries              Maximum number of times to run the process on failure.
     * @return bool $result             True on successful process run, false otherwise.
     */
    private function runMethodRetry($method_name, $method_args = NULL, $retries = 1) {
      $result = false;

      for ($i = 0; $i < $retries; $i++) {
        $result = $this->runMethod($method_name, $method_args);

        if ($result) {
          break;
        }
      }

      return $result;
    }

    /**
     * Installs a plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful install, false otherwise.
     */
    private function installPluginProcess($plugin_id) {
      $result = false;

      $plugin_type = $this->getPluginParameter($plugin_id, 'type');

      if ($plugin_type === 'wordpress') {
        $result = $this->installWordPressPlugin($plugin_id);
      } else if ($plugin_type === 'local') {
        $result = $this->installLocalPlugin($plugin_id);
      }

      if ($result) {
        // clear plugins cache so plugins installed via
        // dynamic file copy are included
        wp_clean_plugins_cache();
      }

      return $result;
    }

    /**
     * Installs a plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful install, false otherwise.
     */
    public function installPlugin($plugin_id) {
      $result = $this->runMethodRetry('installPluginProcess', [$plugin_id], 3);

      return $result;
    }

    /**
     * Installs a WordPress plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful install, false otherwise.
     */
    private function installWordPressPlugin($plugin_id) {
      $result = false;

      $plugin_url = $this->getPluginParameter($plugin_id, 'url');

      if ($plugin_url) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $skin = new WP_Ajax_Upgrader_Skin();
        $plugin_upgrader = new Plugin_Upgrader($skin);

        $result = $plugin_upgrader->install($plugin_url);

        if (is_wp_error($result)) {
          $result = false;
        }
      }

      return $result;
    }

    /**
     * Installs a local plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful install, false otherwise.
     */
    private function installLocalPlugin($plugin_id) {
      $result = false;

      $plugin_path = $this->getPluginParameter($plugin_id, 'path');

      if ($plugin_path) {
        $filesystem_init_result = WP_Filesystem();

        if ($filesystem_init_result) {
          global $wp_filesystem;

          // if file exists, unzip it
          if ($wp_filesystem->exists($plugin_path)) {
            // unzip plugin to upgrade directory
            $file_path = $wp_filesystem->wp_content_dir() . 'upgrade/';
            $file_name = $file_path . $plugin_id;

            // remove file with the same name from upgrade directory if it exists
            if ($wp_filesystem->is_dir($file_name)) {
              $wp_filesystem->delete($file_name, true);
            }

            // unzip file
            $unzipped = unzip_file($plugin_path, $file_path);

            if (is_wp_error($unzipped)) {
              $wp_filesystem->delete($file_name, true);

              return false;
            } else {
              // unzipped correctly, move file
              $plugins_filename = $wp_filesystem->wp_plugins_dir() . $plugin_id;

              // remove file with the same name from plugins directory if it exists
              if ($wp_filesystem->is_dir($plugins_filename)) {
                $wp_filesystem->delete($plugins_filename, true);
              }

              // move plugin
              $moved = $wp_filesystem->move($file_name, $plugins_filename);

              if (!$moved) {
                // delete from upgrade directory
                $wp_filesystem->delete($file_name, true);
              }

              return $moved;
            }
          }
        }
      }

      return $result;
    }

    /**
     * Updates a plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful update, false otherwise.
     */
    private function updatePluginProcess($plugin_id) {
      $result = false;

      $plugin_type = $this->getPluginParameter($plugin_id, 'type');

      if ($plugin_type === 'wordpress') {
        $result = $this->updateWordPressPlugin($plugin_id);
      } else if ($plugin_type === 'local') {
        $result = $this->installLocalPlugin($plugin_id);
      }

      if ($result) {
        // clear plugins cache so plugins updated via
        // dynamic file copy are included
        wp_clean_plugins_cache();
      }

      return $result;
    }

    /**
     * Updates a WordPress plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful update, false otherwise.
     */
    private function updateWordPressPlugin($plugin_id) {
      $result = false;

      $plugin_slug = $this->getPluginParameter($plugin_id, 'slug');

      if ($plugin_slug) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $skin = new WP_Ajax_Upgrader_Skin();
        $plugin_upgrader = new Plugin_Upgrader($skin);

        $result = $plugin_upgrader->upgrade($plugin_slug);

        if (is_wp_error($result)) {
          $result = false;
        }
      }

      return $result;
    }

    /**
     * Updates a plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful update, false otherwise.
     */
    public function updatePlugin($plugin_id) {
      $result = $this->runMethodRetry('updatePluginProcess', [$plugin_id], 3);

      return $result;
    }

    /**
     * Activate a plugin.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id     ID of the plugin.
     * @return bool $result         True on successful activation, false otherwise.
     */
    public function activatePlugin($plugin_id) {
      $result = false;

      $plugin_slug = $this->getPluginParameter($plugin_id, 'slug');

      if ($plugin_slug) {
        $result = activate_plugin($plugin_slug) === NULL;
      }

      return $result;
    }


    /**
     * Returns selected plugin status.
     * 
     * @since 1.0.0
     * 
     * @return array $selected_plugin_status      Selected plugin status.
     */
    public function getSelectedPluginStatus() {
      $selected_plugin_status = maybe_unserialize(get_theme_mod('vikinger_backend_selected_plugins', []));

      return $selected_plugin_status;
    }

    /**
     * Returns selected plugin status.
     * 
     * @since 1.0.0
     * 
     * @param array $selected_plugins         Selected plugins.
     * @return bool $result                   True on successful status update, false otherwise.
     */
    public function updateSelectedPluginStatus($selected_plugins = []) {
      $result = set_theme_mod('vikinger_backend_selected_plugins', maybe_serialize($selected_plugins));

      return $result;
    }

    /**
     * Returns plugin status data.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id               ID of the plugin.
     * @param array $plugin_data              Plugin data.
     * @return array $plugin_status_data      Plugin status data.
     */
    private function getPluginStatusData($plugin_id, $plugin_data) {
      $plugin_installed = $this->isPluginInstalled($plugin_id);

      $plugin_status_data = [
        'id'        => $plugin_id,
        'installed' => $plugin_installed,
        'updated'   => false,
        'active'    => false
      ];

      $plugin_status_data = array_merge($plugin_status_data, $plugin_data);

      if ($plugin_data['type'] === 'wordpress') {
        $plugin_status_data['latest_version'] = $this->getWordPressPluginLatestVersion($plugin_id);
      }

      if ($plugin_installed) {
        $plugin_data = $this->getInstalledPluginData($plugin_id);
        
        $plugin_data_merge = [
          'installed_version' => $plugin_data['Version']
        ];

        $plugin_status_data = array_merge($plugin_status_data, $plugin_data_merge);
        $plugin_status_data['active'] = $this->isPluginActive($plugin_id);
        $plugin_status_data['updated'] = $plugin_status_data['installed_version'] === $plugin_status_data['latest_version'];
      }


      return $plugin_status_data;
    }

    /**
     * Returns plugin status.
     * 
     * @since 1.0.0
     * 
     * @param string $plugin_id                   ID of the plugin.
     * @return array $plugin_status_data          Plugin status.
     */
    public function getPluginStatus($plugin_id = false) {
      $plugin_status_data = [];

      if ($plugin_id && array_key_exists($plugin_id, $this->plugins)) {
        $plugin_data = $this->plugins[$plugin_id];

        $plugin_status_data = $this->getPluginStatusData($plugin_id, $plugin_data);
      } else {
        foreach ($this->plugins as $plugin_id => $plugin_data) {
          $plugin_status_data[] = $this->getPluginStatusData($plugin_id, $plugin_data);
        }
      }

      return $plugin_status_data;
    }
  }
}

?>