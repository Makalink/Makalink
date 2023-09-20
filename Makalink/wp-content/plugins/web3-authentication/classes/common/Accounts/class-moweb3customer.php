<?php
/**
 * MiniOrange enables user to log in through OAuth to apps such as Google, EVE Online etc.
 *  Copyright (C) 2015  miniOrange
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * @package     miniOrange OAuth
 * @license     MIT/Expat
 */

/**
 * This library is miniOrange Authentication Service.
 * Contains Request Calls to Customer service.
 **/

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Accounts
 *
 * WEB3 Account Settings.
 *
 * @category   Core
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */


if ( ! class_exists( ' MoWeb3\MoWeb3Customer' ) ) {
	/**
	 * Accounts
	 *
	 * WEB3 Account Settings.
	 *
	 * @category   Core
	 * @package    MoWeb3
	 * @author     miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link       https://miniorange.com
	 */
	class MoWeb3Customer {

		/**
		 * Customer Email
		 *
		 * @var string
		 */
		public $email;

		/**
		 * Customer Phone
		 *
		 * @var string
		 */
		public $phone;

		/**
		 * Default customer key
		 *
		 * @var string
		 */
		private $default_customer_key = '16555';

		/**
		 * Default API key
		 *
		 * @var string
		 */
		private $default_api_key = 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq';


		/**
		 * Instance helper
		 *
		 * @var  object
		 */
		private $instance_helper;


		/**
		 * Host Name
		 *
		 * @var string
		 */
		private $host_name = '';

		/**
		 * Host key
		 *
		 * @var string
		 */
		private $host_key = '';

		/**
		 * Constructor
		 */
		public function __construct() {
			global $mo_web3_util;
			$this->host_name = $mo_web3_util->mo_web3_get_option( 'mo_web3_host_name' ) ? $mo_web3_util->mo_web3_get_option( 'mo_web3_host_name' ) : 'https://login.xecurify.com';
			$this->email     = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' );
			$this->phone     = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_phone' );
			$this->host_key  = $mo_web3_util->mo_web3_get_option( 'mo_web3_password' );
		}

		/**
		 * Function to register customer.
		 */
		public function create_customer() {
			global $mo_web3_util;
			$url          = $this->host_name . '/moas/rest/customer/add';
			$password     = $this->host_key;
			$first_name   = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_fname' );
			$last_name    = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_lname' );
			$company      = $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_company' );
			$fields       = array(
				'companyName'           => $company,
				'areaOfInterest'        => 'WP Web 3.0 Login',
				'firstname'             => $first_name,
				'lastname'              => $last_name,
				\MoWeb3Constants::EMAIL => $this->email,
				'phone'                 => $this->phone,
				'password'              => $password,
			);
			$field_string = wp_json_encode( $fields );

			return $this->send_request(
				array(),
				false,
				$field_string,
				array(),
				false,
				$url
			);
		}

		/**
		 * Function to retrieve customer key from API.
		 */
		public function get_customer_key() {
			global $mo_web3_util;
			$url          = $this->host_name . '/moas/rest/customer/key';
			$email        = $this->email;
			$password     = $this->host_key;
			$fields       = array(
				\MoWeb3Constants::EMAIL => $email,
				'password'              => $password,
			);
			$field_string = wp_json_encode( $fields );
			return $this->send_request(
				array(),
				false,
				$field_string,
				array(),
				false,
				$url
			);
		}


		/**
		 * Self-Explanatory.
		 */
		public function check_internet_connection() {
			return (bool) @fsockopen( 'login.xecurify.com', 443, $errno, $errstr, 5 ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fsockopen, WordPress.PHP.NoSilencedErrors.Discouraged -- Using default PHP function to check socket connection.
		}

		/**
		 * Function to send Feedback.
		 *
		 * @param string $email   Self Explanatory.
		 * @param string $phone   Self Explanatory.
		 * @param string $message Self Explanatory.
		 */
		public function mo_web3_send_email_alert( $email, $phone, $message ) {
			global $mo_web3_util;
			if ( ! $this->check_internet_connection() ) {
				return;
			}
			$url = $this->host_name . '/moas/api/notify/send';
			global $user;
			$customer_key = $this->default_customer_key;
			$api_key      = $this->default_api_key;

			$current_time_in_millis = self::get_timestamp();
			$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
			$hash_value             = hash( 'sha512', $string_to_hash );
			$from_email             = $email;
			$subject                = 'WordPress Web 3.0 Authentication';
			$site_url               = site_url();
			$user                   = wp_get_current_user();
			$version                = ( \ucwords( \strtolower( $mo_web3_util->get_versi_str() ) ) !== 'Free' ) ? ( \ucwords( \strtolower( $mo_web3_util->get_versi_str() ) ) . ' - ' . \mo_web3_get_version_number() ) : ( ' - ' . \mo_web3_get_version_number() );

			$query   = '[ WordPress Web 3.0 Authentication ' . esc_attr( $version ) . ' ] : ' . esc_attr( $message );
			$server  = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
			$content = '<div >Hello, <br><br>First Name :' . $user->user_firstname . '<br><br>Last  Name :' . $user->user_lastname . '   <br><br>Company :<a href="' . $server . '" target="_blank" >' . $server . '</a><br><br>Phone Number :' . $phone . '<br><br>Email :<a href="mailto:' . $from_email . '" target="_blank">' . $from_email . '</a><br><br>Query :' . $query . '</div>';

			$fields                   = array(
				'customerKey'           => $customer_key,
				'sendEmail'             => true,
				\MoWeb3Constants::EMAIL => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $from_email,
					'bccEmail'    => 'info@xecurify.com',
					'fromName'    => 'miniOrange',
					'toEmail'     => 'web3@xecurify.com',
					'toName'      => 'web3@xecurify.com',
					'subject'     => $subject,
					'content'     => $content,
				),
			);
			$field_string             = wp_json_encode( $fields );
			$headers                  = array( 'Content-Type' => 'application/json' );
			$headers['Customer-Key']  = $customer_key;
			$headers['Timestamp']     = $current_time_in_millis;
			$headers['Authorization'] = $hash_value;
			return $this->send_request(
				$headers,
				true,
				$field_string,
				array(),
				false,
				$url
			);
		}

		/**
		 * Function to submit contactus form.
		 *
		 * @param string  $email Email of the admin.
		 * @param string  $phone Phone of the admin.
		 * @param string  $query Query of the admin.
		 * @param boolean $send_config send plugin config if allowed.
		 */
		public function submit_contact_us( $email, $phone, $query, $send_config = true ) {
			global $current_user;
			global $mo_web3_util;
			wp_get_current_user();
			$customer_key           = $this->default_customer_key;
			$api_key                = $this->default_api_key;
			$current_time_in_millis = time();
			$url                    = $this->host_name . '/moas/api/notify/send';
			$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
			$hash_value             = hash( 'sha512', $string_to_hash );
			$from_email             = $email;
			$version                = ( \ucwords( \strtolower( $mo_web3_util->get_versi_str() ) ) !== 'Free' ) ? ( \ucwords( \strtolower( $mo_web3_util->get_versi_str() ) ) . ' - ' . \mo_web3_get_version_number() ) : ( ' - ' . \mo_web3_get_version_number() );
			$subject                = 'Query for WordPress Web 3.0 Authentication ' . esc_attr( $version ) . ' - ' . esc_attr( $email );
			$query                  = '[WordPress Web 3.0 Authentication ' . esc_attr( $version ) . '] ' . esc_attr( $query );

			$server                   = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
			$content                  = '<div >Hello, <br><br>First Name :' . $current_user->user_firstname . '<br><br>Last  Name :' . $current_user->user_lastname . '   <br><br>Company :<a href="' . $server . '" target="_blank" >' . $server . '</a><br><br>Phone Number :' . $phone . '<br><br>Email :<a href="mailto:' . $from_email . '" target="_blank">' . $from_email . '</a><br><br>Query :' . $query . '</div>';
			$fields                   = array(
				'customerKey'           => $customer_key,
				'sendEmail'             => true,
				\MoWeb3Constants::EMAIL => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $from_email,
					'bccEmail'    => 'web3@xecurify.com',
					'fromName'    => 'miniOrange',
					'toEmail'     => 'web3@xecurify.com',
					'toName'      => 'web3@xecurify.com',
					'subject'     => $subject,
					'content'     => $content,
				),
			);
			$field_string             = wp_json_encode( $fields, JSON_UNESCAPED_SLASHES );
			$headers                  = array( 'Content-Type' => 'application/json' );
			$headers['Customer-Key']  = $customer_key;
			$headers['Timestamp']     = $current_time_in_millis;
			$headers['Authorization'] = $hash_value;
			return $this->send_request(
				$headers,
				true,
				$field_string,
				array(),
				false,
				$url
			);
		}


		/**
		 * Function to get timestamp from API.
		 */
		public function get_timestamp() {
			global $mo_web3_util;
			$url = $this->host_name . '/moas/rest/mobile/get-timestamp';
			return $this->send_request(
				array(),
				false,
				'',
				array(),
				false,
				$url
			);
		}



		/**
		 * Function to check if customer registering already exists.
		 */
		public function check_customer() {
			global $mo_web3_util;
			$url          = $this->host_name . '/moas/rest/customer/check-if-exists';
			$email        = $this->email;
			$fields       = array(
				\MoWeb3Constants::EMAIL => $email,
			);
			$field_string = wp_json_encode( $fields );
			return $this->send_request(
				array(),
				false,
				$field_string,
				array(),
				false,
				$url
			);
		}



		/**
		 * Function to actually send requests
		 *
		 * @param array  $additional_headers Additional headers to send with default headers.
		 * @param bool   $override_headers   self explanatory.
		 * @param string $field_string       Field String.
		 * @param array  $additional_args    Additional args to send with default headers.
		 * @param bool   $override_args      self explanatory.
		 * @param string $url                URL to send request to.
		 */
		private function send_request( $additional_headers = false, $override_headers = false, $field_string = '', $additional_args = false, $override_args = false, $url = '' ) {
			$headers  = array(
				'Content-Type'  => 'application/json',
				'charset'       => 'UTF - 8',
				'Authorization' => 'Basic',
			);
			$headers  = ( $override_headers && $additional_headers ) ? $additional_headers : array_unique( array_merge( $headers, $additional_headers ) );
			$args     = array(
				'method'      => 'POST',
				'body'        => $field_string,
				'timeout'     => '15',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
				'sslverify'   => true,
			);
			$args     = ( $override_args ) ? $additional_args : array_unique( array_merge( $args, $additional_args ), SORT_REGULAR );
			$response = wp_remote_post( $url, $args );

			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo wp_kses( "Something went wrong: $error_message", \mo_web3_get_valid_html() );
				exit();
			}
			return wp_remote_retrieve_body( $response );
		}

	}
}
