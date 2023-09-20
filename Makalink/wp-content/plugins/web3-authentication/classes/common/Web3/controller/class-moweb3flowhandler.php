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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once realpath( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Keccak' . DIRECTORY_SEPARATOR . 'Keccak.php' );
require_once realpath( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Elliptic' . DIRECTORY_SEPARATOR . 'EC.php' );
require_once realpath( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Elliptic' . DIRECTORY_SEPARATOR . 'Curves.php' );
require_once realpath( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Base32' . DIRECTORY_SEPARATOR . 'class-base32.php' );

use Elliptic\EC;
use kornrunner\Keccak;
use Base32\Base32;
use MoWeb3\MoWeb3Utils;

if ( ! class_exists( 'MoWeb3\controller\MoWeb3FlowHandler' ) ) {
	/**
	 * Class to Create MoWeb3 Controller
	 *
	 * @category Common, Core
	 * @package  MoWeb3\controller
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3FlowHandler {
		/**
		 * Instance of utils class
		 *
		 * @var $utils
		 */
		private $utils;

		/**
		 * Testing wallet address for content restriction
		 *
		 * @var $is_testing_wallet_address
		 */
		private $is_testing_wallet_address;
		/**
		 * Contructor
		 */
		public function __construct() {

			$this->utils                     = new \MoWeb3\MoWeb3Utils();
			$this->is_testing_wallet_address = false;// "0x3D9B0A7ef1CcEAda457001A6d51F28FF61E39904";

			add_action( 'wp_ajax_nopriv_type_of_request', array( $this, 'type_of_request' ) );
			add_action( 'wp_ajax_type_of_request', array( $this, 'type_of_request' ) );

			add_action( 'init', array( $this, 'hidden_form_data' ) );
			add_action( 'admin_init', array( $this, 'toggle_crypto_wallet_button_display' ) );
			add_action( 'admin_init', array( $this, 'change_display_button_text' ) );
			add_action( 'admin_init', array( $this, 'nft_save_setting' ) );
		}
		/**
		 * Save crypto wallet display settings
		 */
		public function toggle_crypto_wallet_button_display() {

			if ( isset( $_POST['mo_web3_multiple_button_display_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_multiple_button_display_nonce'] ) ), 'mo_web3_multiple_button_display' ) ) {

				$mo_web3_display_multiple_button = array();

				global $mo_web3_util;

				$multiple_crypto_wallet = $mo_web3_util->get_multiple_crypto_wallet();

				foreach ( $multiple_crypto_wallet as $key => $value ) {
					$name                                     = $value['id'];
					$check                                    = isset( $_POST[ $name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';
					$mo_web3_display_multiple_button[ $name ] = $check;
				}

				$this->utils->mo_web3_update_option( 'mo_web3_display_multiple_button', $mo_web3_display_multiple_button );

			}
		}

		/**
		 * Save content restriction form settings
		 */
		public function nft_save_setting() {

			if ( isset( $_POST['mo_web3_content_restriction_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_content_restriction_nonce'] ) ), 'mo_web3_content_restriction' ) ) {

				$page_url         = isset( $_POST['pageUrl'] ) ? sanitize_text_field( wp_unslash( $_POST['pageUrl'] ) ) : '';
				$contract_address = isset( $_POST['contractAddress'] ) ? sanitize_text_field( wp_unslash( $_POST['contractAddress'] ) ) : '';
				$blockchain       = isset( $_POST['blockchain'] ) ? sanitize_text_field( wp_unslash( $_POST['blockchain'] ) ) : '';

				$page_id = url_to_postid( $page_url );

				if ( 0 === $page_id ) {
					global $mo_web3_util;
					$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Page URL: ' . $page_url . ' does not exists!!' );
					$mo_web3_util->mo_web3_show_error_message();
				} else {

					$this->utils->mo_web3_update_option(
						'mo_web3_nft_settings',
						array(

							'pageID'          => $page_id,
							'contractAddress' => $contract_address,
							'blockchain'      => $blockchain,

						)
					);

					global $mo_web3_util;
					$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'NFT setting saved' );
					$mo_web3_util->mo_web3_show_success_message();

				}
			}
		}


		/**
		 * Save custom text of crypto login button
		 */
		public function change_display_button_text() {

			if ( isset( $_POST['mo_web3_button_custom_text_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_button_custom_text_nonce'] ) ), 'mo_web3_button_custom_text' ) ) {

				$button_text = isset( $_POST['mo_web3_button_custom_text'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_web3_button_custom_text'] ) ) : 'Login with CryptoWallet';

				$this->utils->mo_web3_update_option( 'mo_web3_button_custom_text', $button_text );
				global $mo_web3_util;
				$mo_web3_util->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, 'Login Button Text Changed!' );
				$mo_web3_util->mo_web3_show_success_message();

			}

		}

		/**
		 * Save status of user's NFTs
		 */
		public function hidden_form_data() {

			if ( isset( $_POST['mo_web3_hiddenform_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_web3_hiddenform_nonce'] ) ), 'mo_web3_wp_nonce' ) ) {

				$address   = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
				$nonce     = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
				$has_nft   = isset( $_POST['checkNft'] ) ? sanitize_text_field( wp_unslash( $_POST['checkNft'] ) ) : '';
				$signature = isset( $_POST['signature'] ) ? sanitize_text_field( wp_unslash( $_POST['signature'] ) ) : '';
				$wallets_blockchain = isset( $_POST['walletsBlockchain'] ) ? sanitize_text_field( wp_unslash( $_POST['walletsBlockchain'] ) ) : '';

				$stored_nonce = $this->utils->mo_web3_get_transient( $address );
				$message      = 'Sign this message to validate that you are the owner of the account. Random string: ' . $stored_nonce;

				$is_signature_verified = false;

				if("evm"===$wallets_blockchain){
					$is_signature_verified = $this->verify_signature( $message, $signature, $address );
				}else if("solana"===$wallets_blockchain){
					// this sequence matters, do not change it
					$is_signature_verified = $this->verify_solana_signature($address, $signature);
					$address = json_decode($address) ;
					$stored_nonce = $this->utils->mo_web3_get_transient($address);
				}else if("algorand"===$wallets_blockchain){
					$is_signature_verified = $this->verify_algorand_signature( $address, $signature );
				}

				if ( $nonce === $stored_nonce && $is_signature_verified) {

					$this->utils->mo_web3_user_check( $address );
					$wallet_address = $address;

					$user = get_user_by( 'login', $address );

					clean_user_cache( $user->ID );
					wp_clear_auth_cookie();
					wp_set_current_user( $user->ID );
					wp_set_auth_cookie( $user->ID, true );
					update_user_caches( $user );

					if ( $this->is_testing_wallet_address ) {// for testing purpose.
						$address = $this->is_testing_wallet_address;
					}

					do_action( 'wp_login', $user->data->user_login, $user );

					$key = $user->ID . '_owned_nft';
					update_user_meta( $user->ID, $key, $has_nft );
					update_user_meta( $user->ID, 'wallet_address', $wallet_address );

					$nonce      = uniqid();
					$expiration = 24 * 60 * 60;

					$this->utils->mo_web3_set_transient( $address, $nonce, $expiration );

					if ( wp_safe_redirect( site_url() ) ) {
						exit;
					} else {
						wp_send_json( 'NOT ABLE TO REDIRECT' );
					}
					exit();
				}
			}
		}

		/**
		 * Fetch balance through API for Eth & Poly
		 *
		 * @param string $contract_address NFT contract address.
		 * @param string $wallet_address user's wallet address.
		 * @param string $chain contract deployed chain name.
		 */
		public function get_ethereum_or_polygon_api_data( $contract_address, $wallet_address, $chain ) {

			$url      = null;
			$response = null;
			$args     = array(
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => \MoWeb3Constants::NFT_PORT_AUTHORIZATION_KEY,
				),
			);
			$url      = \MoWeb3Constants::NFT_PORT_API . 'accounts/' . $wallet_address . '?chain=' . $chain . '&contract_address=' . $contract_address;
			$response = wp_remote_get( $url, $args );
			return $response;
		}
		/**
		 * Fetch balance through API for Solana
		 *
		 * @param string $wallet_address user's wallet address.
		 * @param string $solana_field_key solana field key can be hash, collection key or collection id.
		 * @param string $solana_field_value solana field value.
		 */
		public function get_solana_api_data( $wallet_address, $solana_field_key, $solana_field_value ) {

			$url      = null;
			$response = null;
			$args     = array(
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => \MoWeb3Constants::NFT_PORT_AUTHORIZATION_KEY,
				),
			);

			if ( 'solanaMintAddress' === $solana_field_key ) {
				$url = \MoWeb3Constants::NFT_PORT_API . "solana/nft/{$solana_field_value}";
			} elseif ( 'solanaCollectionID' === $solana_field_key || 'solanaCollectionKey' === $solana_field_key ) {
				$url = \MoWeb3Constants::NFT_PORT_API . "solana/nfts/{$solana_field_value}";
			}
			$response = wp_remote_get( $url, $args );

			return $response;
		}
		/**
		 * Fetch balance through API
		 *
		 * @param string $contract_address NFT contract address.
		 * @param string $wallet_address user's wallet address.
		 * @param string $chain contract deployed chain name.
		 * @param string $solana_field_key solana field key can be hash, collection key or collection id.
		 * @param string $solana_field_value solana field value.
		 */
		public function get_token_data_through_api( $contract_address, $wallet_address, $chain, $solana_field_key = null, $solana_field_value = null ) {

			$url      = null;
			$chain    = strtolower( $chain );
			$response = null;
			switch ( $chain ) {
				case 'ethereum':
				case 'polygon':
				case 'goerli':
					$response = $this->get_ethereum_or_polygon_api_data( $contract_address, $wallet_address, $chain );
					break;
				case 'solana':
					$response = $this->get_solana_api_data( $wallet_address, $solana_field_key, $solana_field_value );
					break;
				default:
					$response = array( 'error' => 'invalid case!!' );
					wp_send_json_error( $response, 500 );
			}

			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$error_message = 'Something went wrong: ' . esc_attr( $error_message );
				$response      = array( 'error' => $error_message );
				wp_send_json_error( $response, 500 );
			}
			$response = wp_remote_retrieve_body( $response );
			wp_send_json( $response );
		}

		/**
		 * Fetch balance through API for Polygon testnet
		 *
		 * @param string $contract_address NFT contract address.
		 * @param string $wallet_address user's wallet address.
		 * @param string $chain contract deployed chain name.
		 */
		public function get_polygon_mumbai_testnet_balance( $contract_address, $wallet_address, $chain ) {
			$url              = null;
			$response         = null;
			$chain            = strtolower( $chain );
			$contract_address = strtolower( $contract_address );
			$url              = \MoWeb3Constants::ALCHEMY_MUMBAI_TESTNET_API . \MoWeb3Constants::ALCHEMY_API_KEY . '/getContractsForOwner?owner=' . $wallet_address;
			$response         = wp_remote_get( $url );

			$response = json_decode( $response['body'] );

			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$error_message = 'Something went wrong: ' . esc_attr( $error_message );
				$response      = array( 'error' => $error_message );
				wp_send_json_error( $response, 500 );
			}
			$contracts = $response->contracts;

			foreach ( $contracts as $key => $value ) {
				if ( $value->address === $contract_address ) {
					wp_send_json( $value->numDistinctTokensOwned ); //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- It is a response recieved from alchemy API				
				}
			}
			wp_send_json( '0' );
		}
		/**
		 * Handles form post
		 */
		public function type_of_request() {

			if ( isset( $_REQUEST['mo_web3_verify_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_web3_verify_nonce'] ) ), 'mo_web3_wp_nonce' ) && isset( $_REQUEST['request'] ) ) {

				$request   = sanitize_text_field( wp_unslash( $_REQUEST['request'] ) );
				$address   = isset( $_REQUEST['address'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['address'] ) ) : '';
				$signature = isset( $_REQUEST['signature'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['signature'] ) ) : '';
				switch ( $request ) {
					case 'login':
						$this->handle_login_request( $address );
						break;
					case 'auth':
						$this->handle_auth_request( $address, $signature );
						break;
					case 'getSolanaTokenDetails':
						$wallet_address = isset( $_POST['walletAddress'] ) ? sanitize_text_field( wp_unslash( $_POST['walletAddress'] ) ) : null;
						$field_value    = isset( $_POST['fieldValue'] ) ? sanitize_text_field( wp_unslash( $_POST['fieldValue'] ) ) : null;
						$field_key      = isset( $_POST['fieldKey'] ) ? sanitize_text_field( wp_unslash( $_POST['fieldKey'] ) ) : null;
						$chain          = 'solana';

						$this->get_token_data_through_api( null, $wallet_address, $chain, $field_key, $field_value );
						break;
					case 'getUserHoldNFTData':
						$contract_address = isset( $_POST['contractAddresses'] ) ? sanitize_text_field( wp_unslash( $_POST['contractAddresses'] ) ) : null;
						$chain            = isset( $_POST['blockchain'] ) ? sanitize_text_field( wp_unslash( $_POST['blockchain'] ) ) : null;
						$wallet_address   = isset( $_POST['walletAddress'] ) ? sanitize_text_field( wp_unslash( $_POST['walletAddress'] ) ) : null;
						$this->get_token_data_through_api( $contract_address, $wallet_address, $chain, null );
						break;
					case 'auth_algorand':
						$this->handle_auth_request_algorand( $address, $signature );
						break;
					case 'auth_phantom':
						$this->handle_auth_request_phantom( $address, $signature );
						break;
					case 'getPolygonMumbaiTestnetBalance':
						$contract_address = isset( $_POST['contractAddresses'] ) ? sanitize_text_field( wp_unslash( $_POST['contractAddresses'] ) ) : null;
						$chain            = isset( $_POST['blockchain'] ) ? sanitize_text_field( wp_unslash( $_POST['blockchain'] ) ) : null;
						$wallet_address   = isset( $_POST['wallet_address'] ) ? sanitize_text_field( wp_unslash( $_POST['wallet_address'] ) ) : null;
						$this->get_polygon_mumbai_testnet_balance( $contract_address, $wallet_address, $chain );
						break;
				}
			}
		}

		/**
		 * Phantom Wallet authentication
		 *
		 * @param string $address wallet address.
		 * @param string $signature signatures signed by wallet.
		 */

		public function verify_solana_signature($address, $signature ){
			$signature     = json_decode( $signature );
			$address       = json_decode( $address );
			$nonce         = $this->utils->mo_web3_get_transient( $address );
			$message       = 'Sign this message to validate that you are the owner of the account. Random string: ' . $nonce;
			$verify_result = null;
			
			if ( extension_loaded( 'base58' ) ) {
				$signature     = base58_decode( $signature );
				$pubkey        = base58_decode( $address );
				$verify_result = sodium_crypto_sign_verify_detached( $signature, $message, $pubkey );
			} else {

				$url = \MoWeb3Constants::HASCOIN_SOLANA_SIGNATURE_VERIFICATION_API;

				$headers = array(
					'Content-Type'  => 'application/json',
					'authorization' => \MoWeb3Constants::HASCOIN_AUTHORIZATION_KEY,
				);

				$body = array(
					'message'   => $message,
					'publicKey' => $address,
					'signature' => $signature,
				);

				$args = array(
					'method'  => 'POST',
					'body'    => wp_json_encode( $body ),
					'headers' => $headers,
				);

				$response = wp_remote_post( $url, ( $args ) );
				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					echo 'Something went wrong: ' . esc_attr( $error_message );
					exit();
				}

				$response      = wp_remote_retrieve_body( $response );
				$verify_result = json_decode( $response, true );
				$verify_result = $verify_result['status'];
			}
			return $verify_result;
		}

		public function handle_auth_request_phantom( $address, $signature ) {

			$verify_result = $this->verify_solana_signature($address, $signature);
			
			if ( true === $verify_result || 1 === $verify_result ) {

				$nonce = $this->utils->mo_web3_get_transient( json_decode($address) );

				$admin_nft_setting = $this->utils->mo_web3_get_option( 'mo_web3_nft_settings' );

				$response = array(
					'isSignatureVerified' => 1,
					'nonce'               => $nonce,

				);
				if ( $admin_nft_setting ) {
					$response['adminNftSetting'] = $admin_nft_setting;
				}
				wp_send_json( $response );
			} else {
				$response = array(
					'isSignatureVerified' => 0,
					'nonce'               => null,
				);
				wp_send_json( $response );
			}

		}

		public function verify_algorand_signature($address, $signature ){

			$nonce = $this->utils->mo_web3_get_transient( $address );
			$data  = 'Sign this message to validate that you are the owner of the account. Random string: ' . $nonce;
			$data  = 'MX' . $data;

			$signature = explode( ',', $signature );
			$signature = pack( 'C*', ...$signature );
			$pk = $this->retrieve_public_key_algorand( $address );
			$result = (int) sodium_crypto_sign_verify_detached( $signature, $data, $pk );
			return $result;
		}

		/**
		 * Algorand Wallet authentication
		 *
		 * @param string $address wallet address.
		 * @param string $signature signatures signed by wallet.
		 */
		public function handle_auth_request_algorand( $address, $signature ) {
			
			

			try {
				
				$result = $this->verify_algorand_signature( $address, $signature );

				if ( 1 === $result ) {
					$nonce = $this->utils->mo_web3_get_transient( $address );

					$admin_nft_setting = $this->utils->mo_web3_get_option( 'mo_web3_nft_settings' );

					$response = array(
						'isSignatureVerified' => 1,
						'nonce'               => $nonce,

					);
					if ( $admin_nft_setting ) {
						$response['adminNftSetting'] = $admin_nft_setting;
					}
					wp_send_json( $response );
				} else {
					$response = array(
						'isSignatureVerified' => 0,
						'nonce'               => null,
					);
					wp_send_json( $response );
				}
			} catch ( \Exception $e ) {
				exit();
			}
		}
		/**
		 * Alogrand Wallet authentication Continue
		 *
		 * @param string $address wallet address.
		 */
		public function retrieve_public_key_algorand( $address ) {
			if ( \MoWeb3Constants::ALGORAND_ADDRESS_LENGTH !== strlen( $address ) ) {
				exit();
			}
			$decoded        = Base32::decode( $address );
			$byte_array     = unpack( 'C*', $decoded );
			$pk_uint8_array = array_slice( $byte_array, 0, \MoWeb3Constants::ALGORAND_ADDRESS_BYTE_LENGTH - \MoWeb3Constants::ALGORAND_CHECKSUM_BYTE_LENGTH );
			$pk             = pack( 'C*', ...$pk_uint8_array );
			return $pk;
		}

		/**
		 * Wallet Login
		 *
		 * @param string $address wallet address.
		 */
		public function handle_login_request( $address ) {
			$nonce = $this->utils->mo_web3_get_transient( $address );

			if ( $nonce ) {
				wp_send_json( 'Sign this message to validate that you are the owner of the account. Random string: ' . $nonce );
			} else {
				$nonce      = uniqid();
				$expiration = 24 * 60 * 60;
				$this->utils->mo_web3_set_transient( $address, $nonce, $expiration );
				wp_send_json( 'Sign this message to validate that you are the owner of the account. Random string: ' . $nonce );
			}

		}
		/**
		 * Retrieve address through public key
		 *
		 * @param string $pubkey wallet public key.
		 */
		public function pub_key_to_address( $pubkey ) {
			return '0x' . substr( Keccak::hash( substr( hex2bin( $pubkey->encode( 'hex' ) ), 1 ), 256 ), 24 );
		}
		/**
		 * Verify Signature
		 *
		 * @param string $message plain text message.
		 * @param string $signature signed message.
		 * @param string $address wallet address.
		 */
		public function verify_signature( $message, $signature, $address ) {

			$retrived_pubkey = null;
			if ( extension_loaded( 'bcmath' ) || extension_loaded( 'gmp' ) ) {
				$msglen = strlen( $message );
				$hash   = Keccak::hash( "\x19Ethereum Signed Message:\n{$msglen}{$message}", 256 );
				$sign   = array(
					'r' => substr( $signature, 2, 64 ),
					's' => substr( $signature, 66, 64 ),
				);
				$recid  = ord( hex2bin( substr( $signature, 130, 2 ) ) ) - 27;
				if ( ( $recid & 1 ) !== $recid ) {
					if ( preg_match( '/00$/', $signature ) ) {
						$recid = 0;
					} elseif ( preg_match( '/01$/', $signature ) ) {
						$recid = 1;
					} else {
						return 0;
					}
				}

				$ec               = new EC( 'secp256k1' );
				$retrived_pubkey  = $ec->recoverPubKey( $hash, $sign, $recid );
				$retrived_address = $this->pub_key_to_address( $retrived_pubkey );

			} else {

				$url = \MoWeb3Constants::HASCOIN_ETHEREUM_SIGNATURE_VERIFICATION_API;

				$headers = array(
					'Content-Type'  => 'application/json',
					'authorization' => \MoWeb3Constants::HASCOIN_AUTHORIZATION_KEY,
				);

				$body = array(
					'message'   => $message,
					'signature' => $signature,
				);

				$args = array(
					'method'  => 'POST',
					'body'    => wp_json_encode( $body ),
					'headers' => $headers,
				);

				$response = wp_remote_post( $url, ( $args ) );
				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					echo 'Something went wrong: ' . esc_attr( $error_message );
					exit();
				}
				$response         = wp_remote_retrieve_body( $response );
				$response         = json_decode( $response, true );
				$retrived_address = $response['address'];
			}

			return strtolower( $address ) === strtolower( $retrived_address );
		}
		/**
		 * Wallet authentication
		 *
		 * @param string $address wallet address.
		 * @param string $signature signatures signed by wallet.
		 */
		public function handle_auth_request( $address, $signature ) {

			$nonce   = $this->utils->mo_web3_get_transient( $address );
			$message = 'Sign this message to validate that you are the owner of the account. Random string: ' . $nonce;

			if ( $this->verify_signature( $message, $signature, $address ) ) {
				$nonce = $this->utils->mo_web3_get_transient( $address );

				$admin_nft_setting = $this->utils->mo_web3_get_option( 'mo_web3_nft_settings' );

				$response = array(
					'isSignatureVerified' => 1,
					'nonce'               => $nonce,

				);
				if ( $admin_nft_setting ) {
					$response['adminNftSetting'] = $admin_nft_setting;

				}
				$response['isTesting'] = is_user_logged_in() ? 1 : 0;

				wp_send_json( $response );

			} else {
				$response = array(
					'isSignatureVerified' => 0,
					'nonce'               => null,
				);
				wp_send_json( $response );
			}
		}
	}
}
