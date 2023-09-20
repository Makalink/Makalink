<?php
/**
 * Core
 *
 * WEB3 Login Instance Helper.
 *
 * @category   Common, Core
 * @package    MoWeb3\Base
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( ' MoWeb3\Base\MoWeb3InstanceHelper ' ) ) {

	/**
	 * Class to Select Instance of WEB3 Login.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\Base
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3InstanceHelper {

		/**
		 * WEB3 Login Current Version
		 *
		 * @var string $current_version
		 * */
		private $current_version = 'FREE';

		/**
		 * WEB3 Login common utils
		 *
		 * @var MoWeb3\MoWeb3Utils $utils
		 * */
		private $utils;

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->utils           = new \MoWeb3\MoWeb3Utils();
			$this->current_version = $this->utils->get_versi_str();
		}


		/**
		 * Function to get Account Instance
		 *
		 * @return mixed
		 */
		public function get_accounts_instance() {
			if ( ! class_exists( 'MoWeb3\MoWeb3Accounts' ) ) {
				exit;
			}
			return new \MoWeb3\MoWeb3Accounts();
		}

		/**
		 * Function to get proper All Method Config Settings
		 *
		 * @return mixed
		 */
		public function get_all_method_instances() {

			$all_declared_classes = get_declared_classes();
			$method_classes       = array_filter(
				$all_declared_classes,
				function ( $var ) {
					return ( stripos( $var, 'MoWeb3\Methods' ) !== false );
				}
			);
			unset( $method_classes[ array_search( 'MoWeb3\Methods', $method_classes, true ) ] );
			return $method_classes;
		}




		/**
		 * Function to get proper Settings instance.
		 *
		 * @return mixed
		 */
		public function get_settings_instance() {

			if ( class_exists( 'MoWeb3\MoWeb3FeedbackSettings' ) ) {
				return new \MoWeb3\MoWeb3FeedbackSettings();
			} else {
				wp_die( 'Please Change The version back to what it really was' );
				exit();
			}
		}






		/**
		 * Function to get proper Settings instance.
		 *
		 * @return mixed
		 */
		public function get_config_instance() {

			if ( class_exists( 'MoWeb3\MoWeb3MethodViewHandler' ) ) {

				return new \MoWeb3\MoWeb3MethodViewHandler();
			}
		}

		/**
		 * Function to get proper Utils instance.
		 *
		 * @return mixed
		 */
		public function get_utils_instance() {
			return $this->utils;
		}
	}

}
