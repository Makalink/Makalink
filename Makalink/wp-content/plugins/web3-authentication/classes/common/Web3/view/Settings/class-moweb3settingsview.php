<?php
/**
 * Core
 *
 * Create MoWeb3 Method view Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\view\SettingsView
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\view\SettingsView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\view\ButtonView\MoWeb3View;

if ( ! class_exists( 'MoWeb3\view\SettingsView\MoWeb3SettingsView' ) ) {


	/**
	 * Class to Create MoWeb3 Configuration Tab View.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\view\SettingsView
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3SettingsView {

		/**
		 * Instance of utils class
		 *
		 * @var $util
		 */
		public $util;
		/**
		 * Instance of MoWeb3View class
		 *
		 * @var $button_view
		 */
		public $button_view;
		/**
		 * Constructor
		 */
		public function __construct() {

			$this->util        = new \MoWeb3\MoWeb3Utils();
			$this->button_view = new MoWeb3View();
		}

		/**
		 * Choice to select crypto wallets to be displayed as login option
		 */
		public function toggle_display_of_multiple_login_button() {

			global $mo_web3_util;
			$multiple_crypto_wallet = $mo_web3_util->get_multiple_crypto_wallet();

			?>
				<form id="mo_web3_multiple_button_display" method="post" action="">
					<input type="hidden" name="option" value="mo_web3_multiple_button_display"/>
					<?php wp_nonce_field( 'mo_web3_multiple_button_display', 'mo_web3_multiple_button_display_nonce' ); ?>
					<h6  class="mb-3" for="checkbox">Once enabled,selected Web3 wallet login will appear on the login form.</h6>
					<p>(If none of the Wallets are selected no Web3 wallet login will appear.)</p>
			<?php
					$enabled_crypto_wallet = $this->util->mo_web3_get_option( 'mo_web3_display_multiple_button' );
			foreach ( $multiple_crypto_wallet as $key => $value ) {

				$crypto_wallet = $value;
				$id            = $crypto_wallet['id'];
				$function      = $crypto_wallet['function'];
				$data          = $crypto_wallet['data'];
				$name          = $id;
				?>
						<div class="mb-3">
							<input type="checkbox"  name="<?php echo esc_attr( $name ); ?>"
								<?php
								if ( $enabled_crypto_wallet && isset( $enabled_crypto_wallet[ $name ] ) && 'checked' === $enabled_crypto_wallet[ $name ] ) {
										echo 'checked';
								}
								?>
							>
							<label  class="display-inline" for="checkbox"><?php echo esc_attr( $data ); ?></label>
							<?php
							if ( 'moweb3Phantom' === $name ) {
								echo '</br><small>(If you are using mobile then use phantom mobile app inbuilt browser)</small>';
							}
							?>
						</div>
						<?php
			}

					$base58_extension = 'not_loaded';
			if ( extension_loaded( 'base58' ) ) {
				$base58_extension = 'loaded';
			}

					$base58_extention_url     = \MoWeb3Constants::PHANTOM_BASE58_EXTENSION;
					$base58_git_extention_url = \MoWeb3Constants::PHANTOM_BASE58_GIT_REPO;
			?>
				<button id="submit_multiple_button_display" class="btn btn-primary" type="button">Submit</button>
				</form>			
				<div id="mo_web3_base58_opacity" style="display:none">
					<div id="mo_web3_base58_modal" style="display:none">
						<b>Notice:</b>
						<p style="font-size:medium"> If base58 extension is not installed, latencey will increase for signature verification as we will be using API calls. </p>
						<p style="font-size:medium"> Please refer the below steps to install the base58 extension(optional). </p>

						<div>
							<li>Download this <a href=<?php echo esc_url( $base58_extention_url ); ?> target="blank">Click here</a> base58 PHP extension. </li>
							<li>For more instructions <a href=<?php echo esc_url( $base58_git_extention_url ); ?> target="blank">Click here</a></li>                            
						</div>					
					<div style="cursor:pointer" class="dashicons dashicons-no" onclick="document.getElementById('mo_web3_base58_modal').style.display='none'">
					</div>
				</div>					
			</div>

				<script>


					jQuery("input[name = 'moweb3Phantom']").on('click',(e)=>{
						let isExtensionLoaded = "<?php echo esc_js( $base58_extension ); ?>";

						if(e.target.checked && "not_loaded"==isExtensionLoaded){
							document.getElementById('mo_web3_base58_opacity').style.display='block';
							document.getElementById('mo_web3_base58_modal').style.display='block';
						}
					});
					jQuery("#submit_multiple_button_display").on('click',()=>{				
						var checkboxes = jQuery('#mo_web3_multiple_button_display input[type="checkbox"]');
						let i=0;
						for(i=0;i<checkboxes.length;i++){

							if(checkboxes[i].checked){
								checkboxes[i].value = "checked";
							}else{
								checkboxes[i].value = "unchecked";
							}
						}
						jQuery('#mo_web3_multiple_button_display').submit();
					});

					document.getElementById("mo_web3_base58_opacity").onclick = function(){
						document.getElementById('mo_web3_base58_opacity').style.display = "none";
					}	
				</script> 	
			<?php
		}


		/**
		 * Display form to set custom text for crypto login button
		 */
		public function custom_text_login_button() {
			?>
				<form id="mo_web3_button_custom_text" method="post" action="">

					<input type="hidden" name="option" value="mo_web3_button_display" />
					<?php wp_nonce_field( 'mo_web3_button_custom_text', 'mo_web3_button_custom_text_nonce' ); ?>				
					<div class="row">

						<div class="form-group col-12 col-sm-8">
							<input type="text" name="mo_web3_button_custom_text" class="form-control" placeholder="Your Custom Button text" value="<?php echo esc_attr( $this->get_button_custom_text() ); ?>">
						</div>

						<div class="col-12 col-sm-4">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>				
				</form>	
			<?php
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
				return 'Login with Cryptowallet';
			}

		}

		/**
		 * Display NFTs
		 */
		public function nft_setting() {
			?>
				<form id="mo_web3_nft_setting" class="form-group" action="">

					<div class="form-group mb-3">

						<div class="row">

							<div class="col-12 col-sm-4" >
								<h6>Contract Address:</h6>
							</div>

							<div class="col-12 col-sm-8">
								<input type="text" class="form-control" id="contract_address"  placeholder="Contract Address">
							</div>

						</div>

					</div>

					<button type="button" id="load_button" class="btn btn-primary">Show NFTs</button>

				</form>

				<style>
					.card {
						padding: 1rem;
						border: 1px solid black;
						margin: 1rem;
					}
				</style>
				<div id="nft_display" class="flex gap-7 flex-wrap"></div>			
			<?php
		}


		/**
		 * Test Configuration view on content restriction tab
		 */
		public function test_configuration() {
			?>
				<div style="margin-left:-10px;">
					<?php
					$is_testing = 1;
					$this->button_view->mo_web3_add_login_button( $is_testing );
					?>
				</div>
				<div>
					<button type="button" class="btn btn-primary" id="moweb3_display_modal"  style="display:none"  data-toggle="modal" data-target="#moweb3_test_modal">
						Test Configuration
					</button>

					<div class="modal fade" id="moweb3_test_modal" style="opacity:100%;display:none;" aria-labelledby="moweb3_test_modal_label" aria-hidden="true">
						<div class="modal-dialog" style="min-width:700px;">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="moweb3_test_modal_label">Test Results: Test Successful</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">

									<div class="d-flex justify-content-center">
										<img width="30%"  src= "<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'success-green-check-mark.svg'; ?>"/>
									</div>

									<table class="table table-striped">
										<thead>
											<tr>
												<th scope="col">Attribute Name</th>
												<th scope="col">Attribute Value</th>
											</tr>
										</thead>

										<tbody>
											<tr>
											<th scope="row">Wallet Address</th>
											<td id="wallet_address"></td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
		}
	}
}
?>
