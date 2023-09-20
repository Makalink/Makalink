<?php
/**
 * Core
 *
 * Web3 Method view Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\MoWeb3MethodViewHandler
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\Base\MoWeb3InstanceHelper;
use MoWeb3\view\ButtonView\MoWeb3View;
use MoWeb3\view\SettingsView\MoWeb3SettingsView;



if ( ! class_exists( ' MoWeb3\MoWeb3MethodViewHandler ' ) ) {

	/**
	 * Class to Method View Handler.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\MoWeb3MethodViewHandler
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3MethodViewHandler {

		/**
		 * Instance Helper
		 *
		 * @var \MoWeb3\Base\MoWeb3InstanceHelper $instance_helper
		 * */
		private $instance_helper;
		/**
		 * Instance Config
		 *
		 * @var $moweb3_setting_view
		 * */
		private $moweb3_setting_view;

		/**
		 * Instance View
		 *
		 * @var $moweb3_view
		 * */
		private $moweb3_view;


		/**
		 * Instance Util
		 *
		 * @var $util
		 * */
		public $util;
		/**
		 * Constructor
		 */
		public function __construct() {

			$this->util                = new \MoWeb3\MoWeb3Utils();
			$this->instance_helper     = new MoWeb3InstanceHelper();
			$this->moweb3_view         = new MoWeb3View();
			$this->moweb3_setting_view = new MoWeb3SettingsView();
			wp_enqueue_style( 'mo_web3_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'bootstrap/bootstrap.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			$this->moweb3_view->mo_web3_wp_enqueue();

		}



		/**
		 * Render UI of Config Tab
		 */
		public function render_ui() {
			global $mo_web3_util;
			?>
				<div class="mo_support_layout container">
					<div class="mo_web3_settings_table mt-3">


						<div style="display:flex;justify-content:space-between;min-height:75px">
							<h2>Plugin Configuration : </h2>
							<?php $mo_web3_util->render_setup_guide('https://developers.miniorange.com/docs/wordpress-web3/features/enable-web3-wallets');?>
						</div>					
						<div class="row mb-4">

							<div class="col-12 col-sm-4">
								<h6>Enable Web3 user Login :</h6>
							</div>

							<div class="col-12 col-sm-8">
								<?php $this->moweb3_setting_view->toggle_display_of_multiple_login_button(); ?>
							</div>

						</div>

						<div class="row mb-4">

							<div class="col-12 col-sm-4">
								<h6>Custom Login Button Text:</h6>
							</div>

							<div class="col-12 col-sm-8">
								<?php $this->moweb3_setting_view->custom_text_login_button(); ?>
							</div>

						</div>

						<div class="row mb-4">

							<div class="col-12 col-sm-4">
								<h6>Test All Enabled Cryto Wallet:</h6>
							</div>

							<div class="col-12 col-sm-8">
								<?php $this->moweb3_setting_view->test_configuration(); ?>
							</div>

						</div>


						<div style="display:none">
							<hr>

							<div style="min-height:75px">
								<h2>NFT Setting : </h2>
							</div> 

							<div style="min-height:150px">
								<?php $this->moweb3_setting_view->nft_setting(); ?>
							</div>
						</div>
					</div>
				</div>
				<br>

			<?php
		}

	}
}
?>
