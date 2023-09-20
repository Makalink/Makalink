<?php
/**
 * Plugin Name: WordThree MetaMask Authentication
 * Plugin URI: https://www.wordthree.co.uk
 * Description: Authenticate and Register Users with MetaMask.
 * Version: 1.1.0
 * Author: cudedesign
 * Author URI: https://www.cudedesign.co.uk
 * Requires PHP: 7.3
 * Text Domain: wordthree
 **/

use WordThree\Metamask\Activate;
use WordThree\Metamask\Metamask;

require_once plugin_dir_path(__FILE__) . 'src/Activate.php';
register_activation_hook(__FILE__, [Activate::class, 'activate']);

add_action('plugins_loaded', function () {
	if (!function_exists('is_plugin_active')) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if (!is_plugin_active('wordthree-pro/wordthree.php')) {
		define('WORDTHREE_METAMASK_PLUGIN_PATH', plugin_dir_path(__FILE__));
		define('WORDTHREE_METAMASK_PLUGIN_URL', plugin_dir_url(__FILE__));
		define('WORDTHREE_METAMASK_PLUGIN_VERSION', '1.0.1');

		require_once WORDTHREE_METAMASK_PLUGIN_PATH . 'vendor/autoload.php';

		Metamask::instance();
	}
});
