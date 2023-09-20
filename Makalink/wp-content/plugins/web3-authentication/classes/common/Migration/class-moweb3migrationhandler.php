<?php
/**
 * Core
 *
 * Web3 Migration Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\MoWeb3MigrationHandler
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\Migration;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'MoWeb3\Migration\MoWeb3MigrationHandler' ) ) {
	/**
	 * Class to Migration Handler.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\MoWeb3MigrationHandler
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3MigrationHandler {
		/**
		 * Constructor
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'mo_web3_handle_migration' ) );
		}

		/**
		 * Button settings migration handled
		 */
		public function handle_button_config() {
			global $mo_web3_util;
			$enabled_crypto_wallet                        = $mo_web3_util->mo_web3_get_option( 'mo_web3_display_multiple_button' );
			$enabled_crypto_wallet['moweb3MetaMask']      = 'checked';
			$enabled_crypto_wallet['moweb3WalletConnect'] = 'checked';
			$enabled_crypto_wallet['moweb3Coinbase']      = 'checked';
			$mo_web3_util->mo_web3_update_option( 'mo_web3_display_multiple_button', $enabled_crypto_wallet );

		}
		/**
		 * Handle migration based on the plugin version
		 *
		 * @param string $existing_plugin_version plugin version currently in use.
		 * @param string $current_plugin_version upcoming plugin version.
		 */
		public function mo_web3_update_plugin( $existing_plugin_version, $current_plugin_version ) {

			global $mo_web3_util;

			if ( '2.3.7' >= $existing_plugin_version ) {
				$this->handle_button_config();
			}

			$mo_web3_util->mo_web3_update_option( 'mo_web3_plugin_version', $current_plugin_version );
		}

		/**
		 * Execute migration
		 */
		public function mo_web3_handle_migration() {
			global $mo_web3_util;

			$current_plugin_version  = \mo_web3_get_version_number();
			$existing_plugin_version = $mo_web3_util->mo_web3_get_option( 'mo_web3_plugin_version' );

			if ( $existing_plugin_version <= $current_plugin_version ) {
				$this->mo_web3_update_plugin( $existing_plugin_version, $current_plugin_version );
			}
		}

	}new MoWeb3MigrationHandler();
}

