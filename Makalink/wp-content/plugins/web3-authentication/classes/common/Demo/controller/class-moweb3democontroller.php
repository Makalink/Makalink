<?php
/**
 * Core
 *
 * Create MoWeb3 Method Controller.
 *
 * @category   Common, Core
 * @package    MoWeb3\controller
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\controller;

use MoWeb3\view\AddOnsView\MoWeb3AddOns;

if ( ! class_exists( 'MoWeb3\controller\MoWeb3DemoFlowHandler' ) ) {
	/**
	 * Class to Create MoWeb3 Controller
	 *
	 * @category Common, Core
	 * @package  MoWeb3\controller
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3DemoFlowHandler {
		/**
		 * Contructor
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'demo_trial_request' ) );
		}

		/**
		 * Function to handle automated demo-trial form submission.
		 */
		public function demo_trial_request() {

			if ( isset( $_POST['mo_web3_demo_request_form_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_request_form_nonce'] ) ), 'mo_web3_demo_request_form' ) ) {

				$email                 = isset( $_POST['mo_web3_demo_email'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_email'] ) ) : '';
				$blockchain            = isset( $_POST['mo_web3_demo_blockchain'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_blockchain'] ) ) : '';
				$crypto_wallet         = isset( $_POST['mo_web3_demo_cryptowallet'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_cryptowallet'] ) ) : '';
				$sample_collection_url = isset( $_POST['mo_web3_demo_nft_collection_url'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_nft_collection_url'] ) ) : '';
				$query                 = isset( $_POST['mo_web3_demo_usecase'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_usecase'] ) ) : '';
				$demo_plan             = isset( $_POST['mo_web3_demo_plan'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_demo_plan'] ) ) : '';
				$add_ons               = array();

				global $mo_web3_util;

				if ( $mo_web3_util->mo_web3_check_empty_or_null( $email ) || $mo_web3_util->mo_web3_check_empty_or_null( $blockchain ) || $mo_web3_util->mo_web3_check_empty_or_null( $crypto_wallet ) ) {
					$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Please fill up Usecase, Email field and Requested demo plan to submit your query.' );
					$mo_web3_util->mo_web3_show_error_message();
				} else {

					foreach ( MoWeb3AddOns::$add_ons as $add_on ) {
						foreach ( $add_on['guide'] as $add_on => $properties ) {
							$add_on_path = isset( $_POST[ $properties['demosite_request'] ] ) ? sanitize_text_field( wp_unslash( $_POST[ $properties['demosite_request'] ] ) ) : '';
							if ( '' !== $add_on_path ) {
								array_push( $add_ons, $add_on_path );
							}
						}
					}
					if ( 0 < count( $add_ons ) && true !== str_contains( $demo_plan, 'inclusive' ) ) {
						$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Please choose all-inclusive plan to activate the addon' );
						$mo_web3_util->mo_web3_show_error_message();
						return;
					}
					$add_ons = implode( ',', $add_ons );
					$url     = \MoWeb3Constants::DEMO_SITE;
					$headers = array(
						'Content-Type' => 'application/x-www-form-urlencoded',
						'charset'      => 'UTF - 8',
					);
					$args    = array(
						'method'      => 'POST',
						'body'        => array(
							'option' => 'mo_auto_create_demosite',
							'mo_auto_create_demosite_email' => $email,
							'mo_auto_create_demosite_usecase' => $query,
							'mo_auto_create_demosite_demo_plan' => $demo_plan,
							'mo_auto_create_demosite_addons' => $add_ons,
							'mo_auto_create_demosite_blockchain' => $blockchain,
							'mo_auto_create_demosite_cryptowallet' => $crypto_wallet,
							'mo_auto_create_demosite_sample_collection_url' => $sample_collection_url,
						),
						'timeout'     => '20',
						'redirection' => '5',
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => $headers,
					);

					$response = wp_remote_post( $url, $args );
					if ( is_wp_error( $response ) ) {
						$error_message = $response->get_error_message();
						echo 'Something went wrong: ' . esc_attr( $error_message );
						exit();
					}

					$output = wp_remote_retrieve_body( $response );

					$output = json_decode( $output );

					if ( is_null( $output ) ) {
						$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Something went wrong! contact to your administrator' );
						$mo_web3_util->mo_web3_show_error_message();

					} else {

						if ( 'SUCCESS' === $output->status ) {
							$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, $output->message );
							$mo_web3_util->mo_web3_show_success_message();
							$demo_credentials          = $output->demo_credentials;
							$demo_credentials->add_ons = $add_ons;
							$mo_web3_util->mo_web3_update_option( 'mo_web3_demosite_trial_info', $demo_credentials );
						} else {
							$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, $output->message );
							$mo_web3_util->mo_web3_show_error_message();
						}
					}
				}
			}
		}
	}
}
