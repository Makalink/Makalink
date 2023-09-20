<?php
/**
 * Core
 *
 * WEB3 MoWeb3Loader.
 *
 * @category   Common, Core, UI
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\Base\MoWeb3InstanceHelper;
use MoWeb3\MoWeb3Utils;
use MoWeb3\view\SetupGuideView\MoWeb3GuideView;
use MoWeb3\view\ContentRestrictionView\MoWeb3ContentRestriction;
use MoWeb3\view\PremiumPlan\MoWeb3PremiumPlan;
use MoWeb3\view\ShortcodeInfoView\MoWeb3ShortcodeInfo;
use MoWeb3\view\RoleMappingView\MoWeb3RoleMapping;
use MoWeb3\view\AddOnsView\MoWeb3AddOns;
use MoWeb3\Demo\view\DemoTrialView\MoWeb3DemoTrial;

if ( ! class_exists( 'MoWeb3\Base\MoWeb3Loader' ) ) {
	/**
	 * Class to save Load and Render REST API UI
	 *
	 * @category Common, Core
	 * @package  MoWeb3\Standard
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Loader {

		/**
		 * Instance Helper
		 *
		 * @var \MoWeb3\Base\MoWeb3InstanceHelper $instance_helper
		 **/
		private $instance_helper;

		/**
		 * Instance Util
		 *
		 * @var $util
		 **/
		private $moweb3_util;

		/**
		 * Instance Content Restriction
		 *
		 * @var $moweb3_content_restriction
		 **/
		private $moweb3_content_restriction;

		/**
		 * Instance Licensing
		 *
		 * @var $moweb3_premium_plan
		 **/
		private $moweb3_premium_plan;

		/**
		 * Instance Role Mapping
		 *
		 * @var $moweb3_role_mapping
		 **/
		private $moweb3_role_mapping;

		/**
		 * Instance Shortcode Info
		 *
		 * @var $moweb3_shortcode_info
		 **/
		private $moweb3_shortcode_info;

		/**
		 * Instance Add-ons
		 *
		 * @var $moweb3_add_ons
		 **/
		private $moweb3_add_ons;

		/**
		 * Instance Demo Trial View
		 *
		 * @var $moweb3_demo_trial_request
		 **/
		private $moweb3_demo_trial_request;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_style' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_script' ) );
			$this->moweb3_util     = new MoWeb3Utils();
			$this->instance_helper = new MoWeb3InstanceHelper();
		}

		/**
		 * Function to enqueue CSS
		 */
		public function plugin_settings_style() {
			if ( true === $this->moweb3_util->is_developer_mode ) {
				wp_enqueue_style( 'mo_web3_admin_settings_style', MOWEB3_URL . 'resources/css/dev/style_settings.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
				wp_enqueue_style( 'mo_web3_admin_settings_phone_style', MOWEB3_URL . 'resources/css/dev/phone.css', array(), $ver    = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			} else {
				wp_enqueue_style( 'mo_web3_admin_settings_style', MOWEB3_URL . 'resources/css/prod/style_settings.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
				wp_enqueue_style( 'mo_web3_admin_settings_phone_style', MOWEB3_URL . 'resources/css/prod/phone.min.css', array(), $ver    = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			}
		}

		/**
		 * Function to enqueue JS
		 */
		public function plugin_settings_script() {
			if ( true === $this->moweb3_util->is_developer_mode ) {
				wp_enqueue_script( 'mo_web3_admin_settings_phone_script', MOWEB3_URL . 'resources/js/dev/phone.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			} else {
				wp_enqueue_script( 'mo_web3_admin_settings_phone_script', MOWEB3_URL . 'resources/js/prod/phone.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			}
		}

		/**
		 * Function to load appropriate view
		 *
		 * @param string $currenttab Tab to load and render view for.
		 *
		 * @return void
		 */
		public function load_current_tab( $currenttab ) {
			global $mo_web3_util;
			$accounts = $this->instance_helper->get_accounts_instance();
			if ( 'account' === $currenttab ) {

				if ( $mo_web3_util->mo_web3_get_option( 'mo_web3_verify_customer' ) === 'true' ) {
					$accounts->verify_password_ui();
				} elseif ( trim( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' ) ) !== '' && trim( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_api_key' ) ) === '' && $mo_web3_util->mo_web3_get_option( 'mo_web3_new_registration' ) !== 'true' ) {
					$accounts->verify_password_ui();
				} else {
					$accounts->register();
				}
			} elseif ( 'config' === $currenttab || '' === $currenttab ) {
				$this->instance_helper->get_config_instance()->render_ui();
			} elseif ( 'content_restriction' === $currenttab ) {
				$this->moweb3_content_restriction = new MoWeb3ContentRestriction();
				$this->moweb3_content_restriction->view();
			} elseif ( 'shortcode_info' === $currenttab ) {
				$this->moweb3_shortcode_info = new MoWeb3ShortcodeInfo();
				$this->moweb3_shortcode_info->view();
			} elseif ( 'role_mapping' === $currenttab ) {
				$this->moweb3_role_mapping = new MoWeb3RoleMapping();
				$this->moweb3_role_mapping->view();
			} elseif ( 'licensing' === $currenttab ) {
				$this->moweb3_premium_plan = new MoWeb3PremiumPlan();
				$this->moweb3_premium_plan->view();
			} elseif ( 'add_ons' === $currenttab ) {
				$this->moweb3_add_ons = new MoWeb3AddOns();
				$this->moweb3_add_ons->view();
			} elseif ( 'demo_trial_request' === $currenttab ) {
				$this->moweb3_demo_trial_request = new MoWeb3DemoTrial();
				$this->moweb3_demo_trial_request->view();
			}
		}

	}
}
