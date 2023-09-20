<?php
/**
 * Utils
 *
 * WEB3 Login Utility class.
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

if ( ! class_exists( 'MoWeb3\MoWeb3Utils' ) ) {

	/**
	 * Class containing all utility and helper functions.
	 *
	 * @category Core, Utils
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Utils {



		/**
		 * Developer mode
		 *
		 * @var $is_developer_mode
		 */
		public $is_developer_mode = false;
		/**
		 * Constructor
		 */
		public function __construct() {
			remove_action( 'admin_notices', array( $this, 'mo_web3_success_message' ) );
			remove_action( 'admin_notices', array( $this, 'mo_web3_error_message' ) );
		}



		/**
		 * Create a user when signup using wallet
		 *
		 * @param string $address wallet address.
		 */
		public function mo_web3_user_check( $address ) {
			$user_name  = $address;
			$user_email = '';
			$user_id    = username_exists( $user_name );

			if ( ! $user_id ) {
				$random_password = wp_generate_password( 12, false );
				$user_id         = wp_create_user( $user_name, $random_password, $user_email );
			} else {
				$random_password = __( 'User already exists.  Password inherited.', 'textdomain' );
			}
		}



		/**
		 * Store transient in the form of nonce
		 *
		 * @param string $key transient key.
		 * @param string $value transient value.
		 * @param int    $time transient expiry.
		 */
		public function mo_web3_set_transient( $key, $value, $time ) {
			return set_transient( $key, $value, $time );
		}

		/**
		 * Get WP Transient.
		 *
		 * @param string $key   Option to get.
		 * @return bool
		 * */
		public function mo_web3_get_transient( $key ) {
			return get_transient( $key );
		}

		/**
		 * Delete WP Transient.
		 *
		 * @param string $key   Option to get.
		 * @return bool
		 * */
		public function mo_web3_delete_transient( $key ) {
			return delete_transient( $key );
		}


		/**
		 * Function to display success message
		 */
		public function mo_web3_success_message() {
			$class   = 'updated';
			$message = $this->mo_web3_get_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION );
			echo "<div class='" . esc_attr( $class ) . "'> <p>" . esc_html( $message ) . '</p></div>';
		}


		/**
		 * Function to display error message
		 */
		public function mo_web3_error_message() {
			$class   = 'error';
			$message = $this->mo_web3_get_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION );
			echo "<div class='" . esc_attr( $class ) . "'><p><b>" . esc_html( $message ) . '</b></p></div>';
		}

		/**
		 * Function to hook success message function
		 */
		public function mo_web3_show_success_message() {
			remove_action( 'admin_notices', array( $this, 'mo_web3_error_message' ) );
			add_action( 'admin_notices', array( $this, 'mo_web3_success_message' ) );
		}

		/**
		 * Function to hook error message function
		 */
		public function mo_web3_show_error_message() {
			remove_action( 'admin_notices', array( $this, 'mo_web3_success_message' ) );
			add_action( 'admin_notices', array( $this, 'mo_web3_error_message' ) );
		}

		/**
		 * Is the customer registered?
		 */
		public function mo_web3_is_customer_registered() {
			$email        = $this->mo_web3_get_option( 'mo_web3_admin_email' );
			$customer_key = $this->mo_web3_get_option( 'mo_web3_admin_customer_key' );
			return ( ! $email || ! $customer_key || ! is_numeric( trim( $customer_key ) ) ) ? 0 : 1;

		}
		/**
		 * Get plugin version
		 */
		public function get_versi_str() {
			return 'FREE';
		}

		/**
		 * Function to get the Config Object from DB
		 *
		 * @return mixed
		 * */
		public function get_plugin_config() {
			$config = $this->mo_web3_get_option( 'mo_web3_config_settings' );
			return ( ! $config || empty( $config ) ) ? array() : $config;
		}

		/**
		 * Function to check if given value is null or empty.
		 *
		 * @param mixed $value Thing to check.
		 */
		public function mo_web3_check_empty_or_null( $value ) {
			return ( ! isset( $value ) || empty( $value ) );
		}

		/**
		 * Is cURL installed and enabled?
		 */
		public function mo_web3_is_curl_installed() {
			return (int) ( in_array( 'curl', get_loaded_extensions(), true ) );
		}

		/**
		 * Is cURL installed and enabled?
		 */
		public function mo_web3_show_curl_error() {
			if ( $this->mo_web3_is_curl_installed() === 0 ) {
				$this->mo_web3_update_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION, '<a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled. Please enable it to continue.' );
				$this->mo_web3_show_error_message();
				return;
			}
		}



		/**
		 * Get WP options.
		 *
		 * @param string $key Option to retrieve.
		 * @param string $default Option to retrieve default value.
		 * @return mixed
		 */
		public function mo_web3_get_option( $key, $default = false ) {
			$value = ( is_multisite() ) ? get_site_option( $key, $default ) : get_option( $key, $default );
			return ( ! $value || $default === $value ) ? $default : $value;
		}

		/**
		 * Update WP options.
		 *
		 * @param string $key   Option to Update.
		 * @param mixed  $value Value to set.
		 * @return bool
		 * */
		public function mo_web3_update_option( $key, $value ) {
			return ( is_multisite() ) ? update_site_option( $key, $value ) : update_option( $key, $value );
		}

		/**
		 * Delete WP options.
		 *
		 * @param string $key Option to delete.
		 * @return mixed
		 * */
		public function mo_web3_delete_option( $key ) {
			return ( is_multisite() && $this->check_versi( 3 ) ) ? delete_site_option( $key ) : delete_option( $key );
		}


		/**
		 * Generate Random string
		 *
		 * @param string $length Length of String to generate.
		 *
		 * @return mixed
		 * */
		public function gen_rand_str( $length = 10 ) {
			$characters        = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characters_length = strlen( $characters );
			$random_string     = '';
			for ( $i = 0; $i < $length; $i++ ) {
				$random_string .= $characters[ random_int( 0, $characters_length - 1 ) ];
			}
			return $random_string;
		}

		/**
		 * URL Parser
		 *
		 * @param string $url URL to parse.
		 *
		 * @return mixed
		 */
		public function parse_url( $url ) {
			$retval          = array();
			$parts           = explode( '?', $url );
			$retval['host']  = $parts[0];
			$retval['query'] = isset( $parts[1] ) && '' !== $parts[1] ? $parts[1] : '';
			if ( empty( $retval['query'] ) || '' === $retval['query'] ) {
				return $retval;
			}
			$query_params = array();
			foreach ( explode( '&', $retval['query'] ) as $single_pair ) {
				$parts = explode( '=', $single_pair );
				if ( is_array( $parts ) && count( $parts ) === 2 ) {
					$query_params[ str_replace( 'amp;', '', $parts[0] ) ] = $parts[1];
				}
				if ( is_array( $parts ) && 'state' === $parts[0] ) {
					$parts                 = explode( 'state=', $single_pair );
					$query_params['state'] = $parts[1];
				}
			}
			$retval['query'] = is_array( $query_params ) && ! empty( $query_params ) ? $query_params : array();
			return $retval;
		}

		/**
		 * Generate URL from parsed URL
		 *
		 * @param string $url_obj URL to parse.
		 *
		 * @return string
		 */
		public function generate_url( $url_obj ) {
			if ( ! is_array( $url_obj ) || empty( $url_obj ) ) {
				return '';
			}
			if ( ! isset( $url_obj['host'] ) ) {
				return '';
			}
			$url          = $url_obj['host'];
			$query_string = '';
			$i            = 0;
			foreach ( $url_obj['query'] as $param => $value ) {
				if ( 0 !== $i ) {
					$query_string .= '&';
				}
				$query_string .= "$param=$value";
				++$i;
			}
			return $url . '?' . $query_string;
		}


		/**
		 * Function to get current page URL.
		 */
		public function get_current_url() {
			return ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '' );
		}

		/**
		 * Deactivation hook.
		 */
		public function deactivate_plugin() {
			$this->mo_web3_delete_option( 'mo_web3_host_name' );
			$this->mo_web3_delete_option( 'mo_web3_new_registration' );
			$this->mo_web3_delete_option( 'mo_web3_admin_email' );
			$this->mo_web3_delete_option( 'mo_web3_admin_phone' );
			$this->mo_web3_delete_option( 'mo_web3_admin_fname' );
			$this->mo_web3_delete_option( 'mo_web3_admin_lname' );
			$this->mo_web3_delete_option( 'mo_web3_admin_company' );
			$this->mo_web3_delete_option( \MoWeb3Constants::PANEL_MESSAGE_OPTION );
			$this->mo_web3_delete_option( 'mo_web3_admin_customer_key' );
			$this->mo_web3_delete_option( 'mo_web3_admin_api_key' );
			$this->mo_web3_delete_option( 'mo_web3_new_customer' );
			$this->mo_web3_delete_option( 'mo_web3_registration_status' );
			$this->mo_web3_delete_option( 'mo_web3_customer_token' );
			$this->mo_web3_delete_option( 'mo_web3_lk' );
			$this->mo_web3_delete_option( 'mo_web3_lv' );
		}

		/**
		 * Fetch array of crypto wallets
		 */
		public function get_multiple_crypto_wallet() {
			$is_shortcode           = false;
			$multiple_crypto_wallet = array(
				'metamask'      => array(
					'id'               => 'moweb3MetaMask',
					'function'         => "userLoginOut(0,'metamask',' . esc_attr($is_shortcode) . ');",
					'testing_function' => "userLoginOut(1,'metamask','null');",
					'data'             => 'Metamask',
					'logo'             => array( 'metamask.png' ),
				),
				'walletConnect' => array(
					'id'               => 'moweb3WalletConnect',
					'function'         => "userLoginOut(0,'walletConnect',' . esc_attr($is_shortcode) . ');",
					'testing_function' => "userLoginOut(1,'walletConnect','null');",
					'data'             => 'Wallet Connect',
					'logo'             => array( 'walletconnect.png' ),
				),
				'coinbase'      => array(
					'id'               => 'moweb3Coinbase',
					'function'         => "userLoginOut(0,'coinbase',' . esc_attr($is_shortcode) . ');",
					'testing_function' => "userLoginOut(1,'coinbase','null');",
					'data'             => 'Coinbase Wallet',
					'logo'             => array( 'coinbase.png' ),
				),
				'myalgo'        => array(
					'id'               => 'moweb3Myalgo',
					'function'         => 'connectToMyAlgo(0);',
					'testing_function' => 'connectToMyAlgo(1);',
					'data'             => 'MyAlgo Wallet',
					'logo'             => array( 'myalgo.png' ),
				),
				'phantom'       => array(
					'id'               => 'moweb3Phantom',
					'function'         => 'getAccount(0);',
					'testing_function' => 'getAccount(1);',
					'data'             => 'Phantom Wallet',
					'logo'             => array( 'phantom.png' ),
				),
			);

			return $multiple_crypto_wallet;
		}

		/**
		 * Premium Features Setup Guide.
		 *
		 * @param string $setup_guide is the setup guide url.
		 */
		public function render_setup_guide( $setup_guide ) {        ?>
				<a style="display: flex;" href="<?php echo esc_url($setup_guide);?>" target='_blank'>
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#808080" class="bi bi-info-circle" viewBox="0 0 16 16" style="margin-top:8px;margin-left:10px;">
						<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
					</svg>
				</a>
			<?php
		}

		/**
		 * Premium Features descriptions
		 *
		 * @param string $message message is the description of the premium feature.
		 * @param string $setup_guide is the setup guide url.
		 */
		public function render_premium_info_ui( $message, $setup_guide ) {        ?><div class="prem-icn nameid-prem-img sso-btn-prem-img">
				<img width="35px" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'crown.png'; ?>" />
				<p class="nameid-prem-text"><?php echo esc_attr( $message ); ?><a href="<?php echo esc_url( admin_url( 'admin.php?page=mo_web3_settings&tab=licensing' ) ); ?>" class="text-warning">Click here to upgrade</a></p>
				<?php
				$this->render_setup_guide( $setup_guide );
				?>
			</div><?php
		}
	}
}
?>
