<?php
/**
 * Plugin UI Base Structure
 *
 * WEB3 Login Config guides.
 *
 * @category   Core
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\MoWeb3Support;
use MoWeb3\Base\MoWeb3Loader;




if ( ! class_exists( 'MoWeb3\Base\MoWeb3BaseStructure' ) ) {
	/**
	 * Class to render Basic Structure of plugin UI.
	 *
	 * @category Core
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3BaseStructure {

		/**
		 * Instance of Loader
		 *
		 * @var $loader
		 **/
		private $loader;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			$this->loader = new MoWeb3Loader();
		}


		/**
		 * Function to add Plugin to menu list.
		 */
		public function admin_menu() {
			$page = add_menu_page( 'WEB 3.0 ' . __( 'Configure WEB3', 'mo_web3_settings' ), 'miniOrange WEB3 Login', 'administrator', 'mo_web3_settings', array( $this, 'menu_options' ), MOWEB3_URL . 'resources/images/miniorange.png' );
		}

		/**
		 * Render Skeleton.
		 */
		public function menu_options() {
			global $mo_web3_util;

			$currenttab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( ( $_GET['tab'] ) ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce verification because we are fetching data from URL and not on form submission.
			?>
			<div id="mo_api_authentication_settings">
				<div id='mrablock' class='mweb3-overlay dashboard'></div>
				<div class="miniorange_container">
					<?php
					if ( 'licensing' !== $currenttab ) {
						$this->content_navbar( $currenttab );
						?>
							<table style="width:100%;">
								<tr>
									<td style="vertical-align:top;width:65%;">
									<?php
										$this->loader->load_current_tab( $currenttab );
									?>
									</td>								
									<td style="vertical-align:top;padding-left:1%;">
									<?php
									if ( 'licensing' !== $currenttab ) {
										$support = new MoWeb3Support();
										$support->support();
									}
									?>
									</td>
								</tr>
							</table>
							<?php
					} else {
						$this->loader->load_current_tab( $currenttab );
					}
					?>
				</div>

			</div>
			<?php
		}

		/**
		 * Function to render tabs.
		 *
		 * @param string $currenttab Current active tab.
		 */
		public function content_navbar( $currenttab ) {
			global $mo_web3_util;
			?>
			<div class="wrap">
				<div class="header-warp">
					<h1>miniOrange Web 3.0 Login</h1>

					<div><img style="float:left;" src="<?php echo esc_url( MOWEB3_URL ) . '/resources/images/logo.png'; ?>"></div>
			</div>
			<div id="tab">
			<h2 class="nav-tab-wrapper">
				<a id="tab-config" class="nav-tab <?php echo ( 'config' === esc_attr( $currenttab ) || '' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=config">Configure Settings</a>
				<a  class="nav-tab <?php echo ( 'content_restriction' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=content_restriction">NFT Content Restriction</a>
				<a  class="nav-tab <?php echo ( 'role_mapping' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=role_mapping">Role Mapping</a>
				<a  class="nav-tab <?php echo ( 'shortcode_info' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=shortcode_info">Shortcode Info</a>
				<a  class="nav-tab <?php echo ( 'add_ons' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=add_ons">	Add Ons</a>
				<a  class="nav-tab <?php echo ( 'demo_trial_request' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=demo_trial_request">Demo Trial Request</a>
				<?php if ( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' ) ) { ?>
				<a  class="nav-tab <?php echo ( 'account' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=account">Account Setup</a>
			<?php } ?>

				<a  class="nav-tab <?php echo ( 'licensing' === esc_attr( $currenttab ) ) ? 'mo-web3-nav-tab-active' : ''; ?>" href="admin.php?page=mo_web3_settings&tab=licensing">Licensing</a>

			</h2>
			</div>
			<?php
		}
	}
}
?>
