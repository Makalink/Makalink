<?php
/**
 * Core
 *
 * Create MoWeb3 Method view Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\MoWeb3MethodViewHandler
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\view\ButtonView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoWeb3\view\ButtonView' ) ) {

	/**
	 * Class to Create MoWeb3 Method View Handler.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\MoWeb3MethodViewHandler\CreateMoWeb3View
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3View {

		/**
		 * Instance of utils class
		 *
		 * @var $util
		 */
		public $util;
		/**
		 * Constructor
		 */
		public function __construct() {

			$this->util = new \MoWeb3\MoWeb3Utils();

			$is_testing = 0;
			add_action(
				'login_form',
				function() use ( $is_testing ) {
					$this->mo_web3_add_login_button( $is_testing );
				}
			);

		}



		/**
		 * Enqueue style, css & JS requrired for crypto login button
		 */
		public function mo_web3_wp_enqueue() {

			wp_enqueue_script( 'mo_web3_bootstrap_min_js', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'bootstrap/bootstrap.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			wp_enqueue_script( 'mo_web3_wallet_link', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/wallet-sdk-bundle-walletlink.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			wp_enqueue_script( 'mo_web3_web3Min', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/web3Min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			wp_enqueue_script( 'mo_web3_web3ModalDistIndex', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/web3ModalDistIndex.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			wp_enqueue_script( 'mo_web3_myalgo', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/myalgo.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );

			if ( true === $this->util->is_developer_mode ) {
				wp_enqueue_script( 'mo_web3_nft', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/dev/web3_nft.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_web3_login', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/dev/web3_login.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_web3_modal', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/dev/web3_modal.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_walletconnect_modal', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/dev/walletconnect_modal.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			} else {
				wp_enqueue_script( 'mo_web3_nft', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/prod/web3_nft.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_web3_login', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/prod/web3_login.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_web3_modal', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/prod/web3_modal.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
				wp_enqueue_script( 'mo_web3_walletconnect_modal', MOWEB3_URL . \MoWeb3Constants::WEB3_JS_PATH . 'web3/prod/walletconnect_modal.min.js', array(), $ver = \MoWeb3Constants::VERSION, $in_footer = false );
			}

			$data = array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'wp_nonce' => wp_create_nonce( 'mo_web3_wp_nonce' ),
			);
			add_filter( 'script_loader_tag', array( $this, 'add_type_attribute' ), 10, 3 );

			// Localize the script.
			wp_localize_script( 'mo_web3_web3_login', 'mo_web3_utility_object', $data );
			wp_enqueue_style( 'mo_web3_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'bootstrap/bootstrap.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );

			if ( true === $this->util->is_developer_mode ) {
				wp_enqueue_style( 'mo_web3_custom_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'dev/styles.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
				wp_enqueue_style( 'mo_web3_licensing_plan_view_page_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'dev/mo-web3-licensing.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			} else {
				wp_enqueue_style( 'mo_web3_custom_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'prod/styles.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
				wp_enqueue_style( 'mo_web3_licensing_plan_view_page_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'prod/mo-web3-licensing.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			}
		}
		/**
		 * Returns custom text set for crypto login button
		 *
		 * @param string $tag is script tag of js file.
		 * @param string $handle is name of enqueued script.
		 * @param string $src is url of the js enqueued.
		 */
		public function add_type_attribute( $tag, $handle, $src ) {
			// if not your script, do nothing and return original $tag.
			if ( 'mo_web3_walletconnect_modal' !== $handle ) {
				return $tag;
			}
			// change the script tag by adding type="module" and return it.
			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
			return $tag;
		}
		/**
		 * Returns custom text set for crypto login button
		 */
		public function get_button_custom_text() {

			$value = $this->util->mo_web3_get_option( 'mo_web3_button_custom_text' );

			if ( $value ) {
				return $value;
			} else {
				$this->util->mo_web3_update_option( 'mo_web3_button_custom_text', 'Login with Cryptowallet' );
				$this->get_button_custom_text();
			}

		}


		/**
		 * View for crypto wallet login button
		 *
		 * @param int $is_testing is_testing is true if login initiated during test connectivity button of admin dashboard.
		 */
		public function mo_web3_add_login_button( $is_testing = 0 ) {

			$this->mo_web3_wp_enqueue();

			global $mo_web3_util;

			$multiple_crypto_wallet = $mo_web3_util->get_multiple_crypto_wallet();

			$all_buttons = $this->util->mo_web3_get_option( 'mo_web3_display_multiple_button' );

			$display_button = true;

			if ( $all_buttons ) {
				$num_of_btn_disabled = 0;
				foreach ( $all_buttons as $key => $value ) {

					if ( '' === $all_buttons[ $key ] ) {// checking that the button is diabled.
						$num_of_btn_disabled++;
					}
				}
				if ( count( $all_buttons ) === $num_of_btn_disabled ) {// true , when all buttons are disabled.
					$display_button = false;
				}
			}

			if ( $display_button ) {
				?>

			<div>
				&nbsp;&nbsp;<button onclick="clearMessage();" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#multipleCryptowalletModal"  type="button" id="buttonText"  >
					<?php
					if ( $is_testing ) {
						echo 'Test Web3 Connectivity';
					} else {
						echo esc_attr( $this->get_button_custom_text() );
					}
					?>
					</button>
			</div>
			<?php } ?>
			<!-- Modal -->
			<div  class="modal fade"  style="opacity:100%" id="multipleCryptowalletModal" role="dialog" aria-labelledby="multipleCryptowalletModalTitle" aria-hidden="true">
				<div style="z-index:1000" class="modal-dialog modal-dialog-centered" style="max-width:600px;" role="document">
					<div class="modal-content">

						<div class="modal-header">
							<div>
								<h5 class="modal-title" id="exampleModalLongTitle">Connect to your favourite CryptoWallet</h5>
								<div id="moweb3CustomErrorMessage"></div>
							</div>
						</div>

						<div class="modal-body m-0 p-0" >

						<?php

						$all_buttons = $this->util->mo_web3_get_option( 'mo_web3_display_multiple_button' );

						if ( false === $all_buttons ) {
							?>
							<div class="hover" onclick="userLoginOut(<?php echo esc_attr( $is_testing ); ?>);" style="min-height:140px;">

								<div class="mb-3 pt-2 center">								
									<img class="mr-3" width="30" height="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'cryptowallet_images/metamask.png'; ?>"/>&nbsp;&nbsp;&nbsp;
									<img class="mr-3" width="30" height="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'cryptowallet_images/coinbase.png'; ?>"/>&nbsp;&nbsp;&nbsp;
									<img class="mr-3" width="30" height="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'cryptowallet_images/walletconnect.png'; ?>"/>

								</div>

								<div class="mb-1 center">
									<h5>MetaMask, Coinbase, Wallet Connect</h5>
								</div>

								<div style="color:#B2B2B2" class="center">
									<p style="font-size:1rem;">Connect to your MetaMask, Coinbase, Wallet Connect</p>
								</div>

							</div>

							<?php
						} else {

							foreach ( $multiple_crypto_wallet as $key => $value ) {

								$name     = $value['id'];
								$function = $is_testing ? $value['testing_function'] : $value['function'];
								$id       = $name;
								if ( $all_buttons && isset( $all_buttons[ $name ] ) && 'checked' === $all_buttons[ $name ] ) {
									?>
										<div onclick="
										<?php
										if ( 'moweb3WalletConnect' !== $id ) {
											echo esc_attr( $function );
										}
										?>
										" id="<?php echo esc_attr( $id ); ?>" class="hover" style="min-height:140px;">

											<div class="mb-3 pt-2 center">
												<?php
												$wallet_images       = $value['logo'];
												$wallet_images_count = count( $wallet_images );
												for ( $i = 0;$i < $wallet_images_count; $i++ ) {
													?>
													<img width="30" height="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'cryptowallet_images/' . esc_attr( $wallet_images[ $i ] ); ?>"/>&nbsp;&nbsp;&nbsp;
												<?php } ?>
											</div>

											<div class="mb-1 center">
												<h5><?php echo esc_attr( $value['data'] ); ?></h5>
											</div>

											<div style="color:#B2B2B2" class="center">
												<p style="font-size:1rem;">Connect to your <?php echo esc_html( $value['data'] ); ?></p>
											</div>

										</div>
										<hr>
										<?php
								}
							}
						}
						?>
					</div>
				</div>
			</div>       
		</div>
			<?php
		}
	}
}
?>
