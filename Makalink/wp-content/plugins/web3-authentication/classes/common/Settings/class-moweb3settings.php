<?php
/**
 * App
 *
 * WEB3 Common Settings.
 *
 * @category   Common, Core
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\MoWeb3Utils;

if ( ! class_exists( 'MoWeb3\MoWeb3Settings' ) ) {


	/**
	 * Class for WEB3 Settings.
	 *
	 * @category Common, Core
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Settings {

		/**
		 * Web 3.0 Plugin Configuration
		 *
		 * @var Array $config
		 * */
		public $config;

		/**
		 * Web 3.0 utils
		 *
		 * @var \MoWEB3\mo_web3_utils $util
		 * */
		public $util;
		/**
		 * Constructor.
		 */
		public function __construct() {

			global $mo_web3_util;
			$this->util = $mo_web3_util;
			add_action( 'admin_init', array( $this, 'miniorange_web3_save_settings' ) );
			$this->config = $this->util->get_plugin_config();

		}



		/**
		 * Saves Settings.
		 *
		 * @return void
		 */
		public function miniorange_web3_save_settings() {

			if ( isset( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && current_user_can( 'administrator' ) ) {

				if ( isset( $_POST['mo_web3_change_miniorange_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_change_miniorange_nonce'] ) ), 'mo_web3_change_miniorange' ) && isset( $_POST[ \MoWeb3Constants::OPTION ] ) && 'mo_web3_change_miniorange' === sanitize_text_field( wp_unslash( $_POST[ \MoWeb3Constants::OPTION ] ) ) ) {
					mo_web3_deactivate();
					return;
				}

				if ( isset( $_POST['mo_web3_verify_customer_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_verify_customer_nonce'] ) ), 'mo_web3_verify_customer' ) && isset( $_POST[ \MoWeb3Constants::OPTION ] ) && 'mo_web3_verify_customer' === sanitize_text_field( wp_unslash( $_POST[ \MoWeb3Constants::OPTION ] ) ) ) {
					// register the admin to miniOrange.
					if ( $this->util->mo_web3_is_curl_installed() === 0 ) {
						return $this->util->mo_web3_show_curl_error();
					}
					// validation and sanitization.
					$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
					$password = isset( $_POST['password'] ) ? stripslashes( $_POST['password'] ) : '';//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization. Preventing use of sanitization in password will lead to removal of special characters.
					if ( $this->util->mo_web3_check_empty_or_null( $email ) || $this->util->mo_web3_check_empty_or_null( $password ) ) {
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'All the fields are required. Please enter valid entries.' );
						$this->util->mo_web3_show_error_message();
						return;
					}

					$this->util->mo_web3_update_option( 'mo_web3_admin_email', $email );
					$this->util->mo_web3_update_option( 'mo_web3_password', $password );

					$customer = new MoWeb3Customer();
					$content  = $customer->get_customer_key();

					$customer_key = json_decode( $content, true );
					if ( json_last_error() === JSON_ERROR_NONE ) {
						$this->util->mo_web3_update_option( 'mo_web3_admin_customer_key', sanitize_text_field( $customer_key['id'] ) );
						$this->util->mo_web3_update_option( 'mo_web3_admin_api_key', sanitize_text_field( $customer_key['apiKey'] ) );
						$this->util->mo_web3_update_option( 'mo_web3_customer_token', sanitize_text_field( $customer_key['token'] ) );
						if ( isset( $customer_key['phone'] ) ) {
							$this->util->mo_web3_update_option( 'mo_web3_admin_phone', sanitize_text_field( $customer_key['phone'] ) );
						}
						$this->util->mo_web3_delete_option( 'mo_web3_password' );
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Customer retrieved successfully' );
						$this->util->mo_web3_delete_option( 'mo_web3_verify_customer' );
						$this->util->mo_web3_show_success_message();
					} else {
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Invalid username or password. Please try again.' );
						$this->util->mo_web3_show_error_message();
					}
				}

				if ( isset( $_POST['mo_web3_contact_us_query_option_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_contact_us_query_option_nonce'] ) ), 'mo_web3_contact_us_query_option' ) && isset( $_POST[ \MoWeb3Constants::OPTION ] ) && 'mo_web3_contact_us_query_option' === sanitize_text_field( wp_unslash( $_POST[ \MoWeb3Constants::OPTION ] ) ) ) {
					if ( $this->util->mo_web3_is_curl_installed() === 0 ) {
						return $this->util->mo_web3_show_curl_error();
					}
					// Contact Us query.
					$email = isset( $_POST['mo_web3_contact_us_email'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_contact_us_email'] ) ) : '';
					$phone = isset( $_POST['mo_web3_contact_us_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_contact_us_phone'] ) ) : '';
					$query = isset( $_POST['mo_web3_contact_us_query'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_contact_us_query'] ) ) : '';

					$customer = new MoWeb3Customer();
					if ( $this->util->mo_web3_check_empty_or_null( $email ) || $this->util->mo_web3_check_empty_or_null( $query ) ) {
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Please fill up Email and Query fields to submit your query.' );
						$this->util->mo_web3_show_error_message();
					} else {
						$send_config = false;
						$submited    = $customer->submit_contact_us( $email, $phone, $query, $send_config );
						if ( false === $submited ) {
							$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Your query could not be submitted. Please try again.' );
							$this->util->mo_web3_show_error_message();
						} else {
							$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Thanks for getting in touch! We shall get back to you shortly.' );
							$this->util->mo_web3_show_success_message();
						}
					}
				}

				if ( isset( $_POST['mo_web3_register_customer_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_register_customer_nonce'] ) ), 'mo_web3_register_customer' ) && isset( $_POST[ \MoWeb3Constants::OPTION ] ) && 'mo_web3_register_customer' === sanitize_text_field( wp_unslash( $_POST[ \MoWeb3Constants::OPTION ] ) ) ) {
					// register the admin to miniOrange
					// validation and sanitization.
					$email            = '';
					$phone            = '';
					$password         = '';
					$fname            = '';
					$lname            = '';
					$company          = '';
					$confirm_password = '';
					if ( ! isset( $_POST['email'] ) || ! isset( $_POST['password'] ) || ! isset( $_POST['confirmPassword'] ) || $this->util->mo_web3_check_empty_or_null( sanitize_text_field( wp_unslash( $_POST['email'] ) ) ) || $this->util->mo_web3_check_empty_or_null( stripslashes( $_POST['password'] ) ) || $this->util->mo_web3_check_empty_or_null( stripslashes( $_POST['confirmPassword'] ) ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization. Preventing use of sanitization in password will lead to removal of special characters.
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'All the fields are required. Please enter valid entries.' );
						$this->util->mo_web3_show_error_message();
						return;
					}
					if ( strlen( stripslashes( $_POST['password'] ) ) < 8 || strlen( stripslashes( $_POST['confirmPassword'] ) ) < 8 ) {//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization. Preventing use of sanitization in password will lead to removal of special characters.
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Choose a password with minimum length 8.' );
						$this->util->mo_web3_show_error_message();
						return;
					} else {
						$email            = sanitize_email( wp_unslash( $_POST['email'] ) );
						$phone            = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
						$password         = stripslashes( $_POST['password'] );//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization. Preventing use of sanitization in password will lead to removal of special characters.
						$fname            = isset( $_POST['fname'] ) ? sanitize_text_field( wp_unslash( $_POST['fname'] ) ) : '';
						$lname            = isset( $_POST['lname'] ) ? sanitize_text_field( wp_unslash( $_POST['lname'] ) ) : '';
						$company          = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
						$confirm_password = stripslashes( $_POST['confirmPassword'] );//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization. Preventing use of sanitization in password will lead to removal of special characters.
					}

					$this->util->mo_web3_update_option( 'mo_web3_admin_email', $email );
					$this->util->mo_web3_update_option( 'mo_web3_admin_phone', $phone );
					$this->util->mo_web3_update_option( 'mo_web3_admin_fname', $fname );
					$this->util->mo_web3_update_option( 'mo_web3_admin_lname', $lname );
					$this->util->mo_web3_update_option( 'mo_web3_admin_company', $company );

					if ( $this->util->mo_web3_is_curl_installed() === 0 ) {// ?
						return $this->util->mo_web3_show_curl_error();
					}

					if ( strcmp( $password, $confirm_password ) === 0 ) {
						$this->util->mo_web3_update_option( 'mo_web3_password', $password );
						$customer = new MoWeb3Customer();
						$email    = $this->util->mo_web3_get_option( 'mo_web3_admin_email' );
						$content  = json_decode( $customer->check_customer(), true );
						if ( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND' ) === 0 ) {
							$this->create_customer();
						} else {
							$this->mo_web3_get_current_customer();
						}
					} else {
						$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Passwords do not match.' );
						$this->util->mo_web3_update_option( 'mo_web3_verify_customer', false );
						$this->util->mo_web3_show_error_message();
					}
				}
				if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_web3_goto_login' && isset( $_REQUEST['mo_web3_goto_login_form_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_web3_goto_login_form_field'] ) ), 'mo_web3_goto_login_form' ) ) {
					delete_option( 'mo_web3_new_registration' );
					update_option( 'mo_web3_verify_customer', 'true' );
				}
				if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_web3_change_email' && isset( $_REQUEST['mo_web3_change_email_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_web3_change_email_nonce'] ) ), 'mo_web3_change_email' ) ) {
					update_option( 'mo_web3_verify_customer', '' );
					update_option( 'mo_web3_registration_status', '' );
					update_option( 'mo_web3_new_registration', 'true' );
				}
			}
		}

		/**
		 * Function to fetch current customer
		 */
		public function mo_web3_get_current_customer() {

			$customer     = new MoWeb3Customer();
			$content      = $customer->get_customer_key();
			$customer_key = json_decode( $content, true );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				$this->util->mo_web3_update_option( 'mo_web3_admin_customer_key', sanitize_text_field( $customer_key['id'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_admin_api_key', sanitize_text_field( $customer_key['apiKey'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_customer_token', sanitize_text_field( $customer_key['token'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_password', '' );
				$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Customer retrieved successfully' );
				$this->util->mo_web3_delete_option( 'mo_web3_verify_customer' );
				$this->util->mo_web3_delete_option( 'mo_web3_new_registration' );
				$this->util->mo_web3_show_success_message();
			} else {
				$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'You already have an account with miniOrange. Please enter a valid password.' );
				$this->util->mo_web3_update_option( 'mo_web3_verify_customer', 'true' );
				$this->util->mo_web3_show_error_message();
			}
		}

		/**
		 * Create customer from API wrapper.
		 */
		public function create_customer() {
			global $mo_web3_util;
			$customer     = new MoWeb3Customer();
			$customer_key = json_decode( $customer->create_customer(), true );

			if ( strcasecmp( $customer_key['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS' ) === 0 ) {
				$this->mo_web3_get_current_customer();
				$this->util->mo_web3_delete_option( 'mo_web3_new_customer' );
			} elseif ( strcasecmp( $customer_key['status'], 'SUCCESS' ) === 0 ) {
				$this->util->mo_web3_update_option( 'mo_web3_admin_customer_key', sanitize_text_field( $customer_key['id'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_admin_api_key', sanitize_text_field( $customer_key['apiKey'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_customer_token', sanitize_text_field( $customer_key['token'] ) );
				$this->util->mo_web3_update_option( 'mo_web3_password', '' );
				$this->util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Registered successfully.' );
				$this->util->mo_web3_update_option( 'mo_web3_registration_status', 'mo_web3_REGISTRATION_COMPLETE' );
				$this->util->mo_web3_update_option( 'mo_web3_new_customer', 1 );
				$this->util->mo_web3_delete_option( 'mo_web3_verify_customer' );
				$this->util->mo_web3_delete_option( 'mo_web3_new_registration' );
				$this->util->mo_web3_show_success_message();
			}
		}
	}
}
