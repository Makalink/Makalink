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

namespace MoWeb3\view\ShortcodeInfoView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoWeb3\view\ShortcodeInfoView\MoWeb3ShortcodeInfo' ) ) {

	/**
	 * Class to Create MoWeb3 Shortcode Tab View.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\view\ShortcodeInfoView
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3ShortcodeInfo {

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
			$this->button_view = new \MoWeb3\view\ButtonView\MoWeb3View();
			$this->button_view->mo_web3_wp_enqueue();

		}
		/**
		 * Shortcode Info Tab view
		 */
		public function view() {
			?>
				<div  class="mo_support_layout container prem-info"  id="web3Shortcode" style="font-size:0.9rem">
					<?php
					$this->util->render_premium_info_ui( 'The Shortcode for Login Button is available in standard and higher plans. ', 'https://developers.miniorange.com/docs/wordpress-web3/features/shortcode' );
					?>
					<h3 >Sign in options</h3><br>
					<strong >
					Option 1: Use a Login button on WordPress default Login Form for different providers login method.</strong>
					<ol>
						<li>Go to Configure Settings tab.</li>
						<li>Check <b>"Enable Web3 user Login"</b>.</li>
					</ol>
					<strong>Option 2: Use a Shortcode</strong>
					<ol style="list-style:none">						
						<li>Place shortcode <b>[mo_web3_login_button_shortcode <i>redirection_url</i>="https://example.com" <i>text_color</i>="black" <i>button_text</i>="Custom Text on Wallet Button"]</b> to add Web3 Login button on WordPress pages.<br><br>
							<ol style="list-style:disc" >
								<li><b>redirection_url</b>,will direct the user on the given url</li>
								<li>After login through the web3 login button, button will replaced by the wallet address <b>text_color</b> defines the color of the wallet address</li>								
								<li><b>button_text</b>, Display your Custom Text on Cryptowallet Button</li>
							</ol>
						</li>
					</ol>
				</div>
				</br>
				<div class="mo_support_layout container prem-info" style="font-size:0.9rem">
				<?php
					$this->util->render_premium_info_ui( 'The Shortcode to gate specific section of page for crypto wallet users is available in standard and higher plans. ', '' );
				?>
				<h3 >Sign out options</h3><br>
					<ol style="list-style:disc">					
						<li>Place shortcode <b>[mo_web3_disconnect_wallet]</b> to add Web3 Disconnect Wallet Button on WordPress pages.<br><br>
						</li>						
						<li><b>[mo_web3_backup_wallet_address]</b> If a native WordPress user (user that login using username and password) disconnects their wallet from  their WordPress profile. You can use this shortcode, to display them wallet address they disconnected. <br><br>
						</li>
					</ol>
				</div>
				</br>
				<div class="mo_support_layout container prem-info" style="font-size:0.9rem">
					<?php
						$this->util->render_premium_info_ui( 'The Shortcode to gate specific section of page for crypto wallet users is available in standard and higher plans. ', 'https://developers.miniorange.com/docs/wordpress-web3/features/shortcode#content-gating');
					?>
					<h3>Partial Page/Post Token Gating</h3><br>
					<strong>Use a Shortcode: </strong><span>Place your content between the shortcode.</span><br>
					<ol style="list-style:none">
						<b>[mo_web3_post_restriction_shortcode contract_address_name="contract-address-name-1,contract-address-name-2"]</b>
						<p style="margin:3px;margin-left:30px;" >&lt; Content that you want to partial token gate &gt;</p>
						<b>[/mo_web3_post_restriction_shortcode]</b>
					</ol>
					<br>
					<p> <span class="moweb3-text-danger">Note:</span> Do not leave any unwanted white spaces in the shortcode.</p>			
				</div>

		</br><?php
		}
	}
}
?>
