<?php
/**
 * App
 *
 * WEB3 Settings Controller.
 *
 * @category   Core
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\MoWeb3Settings;
use MoWeb3\MoWeb3Customer;

if ( ! class_exists( ' MoWeb3\MoWeb3FeedbackSettings ' ) ) {

	/**
	 * Class for Free WEB3 Settings
	 *
	 * @category Core
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3FeedbackSettings {

		/**
		 * WEB3 Common Settings
		 *
		 * @var \MoWeb3\Settings $common_settings
		 * */
		private $common_settings;

		/**
		 * Constructor
		 *
		 * @return void
		 **/
		public function __construct() {

			$this->common_settings = new MoWeb3Settings();
			add_action( 'admin_init', array( $this, 'mo_web3_free_settings' ) );
			add_action( 'admin_footer', array( $this, 'mo_web3_feedback_request' ) );
		}


		/**
		 * Function to Save All Sorts of settings
		 *
		 * @return void
		 **/
		public function mo_web3_free_settings() {

			global $mo_web3_util;

			if ( isset( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && current_user_can( 'administrator' ) ) {

				if ( isset( $_POST['mo_web3_feedback_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_feedback_nonce'] ) ), 'mo_web3_feedback' ) && isset( $_POST[ \MoWeb3Constants::OPTION ] ) && 'mo_web3_feedback' === sanitize_text_field( wp_unslash( $_POST[ \MoWeb3Constants::OPTION ] ) ) ) {

					$user                      = wp_get_current_user();
					$message                   = 'Plugin Deactivated:';
					$deactivate_reason         = isset( $_POST['mo_web3_deactivate_reason_radio'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_deactivate_reason_radio'] ) ) : false;
					$deactivate_reason_message = isset( $_POST['mo_web3_query_feedback'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_query_feedback'] ) ) : false;
					if ( ! $deactivate_reason ) {
						$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Please Select one of the reasons ,if your reason is not mentioned please select Other Reasons' );
						$mo_web3_util->mo_web3_show_error_message();
					}
					$message .= $deactivate_reason;
					if ( isset( $deactivate_reason_message ) ) {
						$message .= ':' . $deactivate_reason_message;
					}
					$email = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' );
					if ( '' === $email ) {
						$email = $user->user_email;
					}
					$phone = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_phone' );
					// only reason.
					$feedback_reasons = new MoWeb3Customer();

					$submited = json_decode( $feedback_reasons->mo_web3_send_email_alert( $email, $phone, $message ), true );
					deactivate_plugins( MOWEB3_DIR . DIRECTORY_SEPARATOR . 'miniorange-web3-login-settings.php' );
					$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Thank you for the feedback.' );
					$mo_web3_util->mo_web3_show_success_message();
				}
				if ( isset( $_POST['mo_web3_skip_feedback_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_skip_feedback_nonce'] ) ), 'mo_web3_skip_feedback' ) && isset( $_POST['option'] ) && 'mo_web3_skip_feedback' === sanitize_text_field( wp_unslash( $_POST['option'] ) ) ) {
					deactivate_plugins( MOWEB3_DIR . DIRECTORY_SEPARATOR . 'miniorange-web3-login-settings.php' );
					$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Plugin Deactivated Successfuly. We will get back to you shortly.' );
					$mo_web3_util->mo_web3_show_success_message();
				}
			}

		}

		/**
		 * Feedback form
		 */
		public function mo_web3_feedback_request() {
			$feedback = new \MoWeb3\MoWeb3Feedback();
			$feedback->show_form();
		}
	}
}
