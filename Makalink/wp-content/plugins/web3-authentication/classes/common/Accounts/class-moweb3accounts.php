<?php
/**
 * Accounts
 *
 * WEB3 Premium Accounts.
 *
 * @category   Core
 * @package    MoWeb3\Paid
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\MoWeb3Support;


if ( ! class_exists( ' MoWeb3\MoWeb3Accounts ' ) ) {

	/**
	 * Class to save and render WEB3 Login Accounts
	 *
	 * @category Core, Accounts
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Accounts {

		/**
		 * Function to render UI.
		 */
		public function register() {
			global $mo_web3_util;

			if ( $mo_web3_util->mo_web3_is_customer_registered() ) {
				self::show_customer_info();
			} elseif ( 'FREE' === $mo_web3_util->get_versi_str() ) {
				self::mo_web3_show_new_registration_page();
			} else {
				self::verify_password_ui();
			}
		}

		/**
		 * Function to render new registrations page.
		 */
		public function mo_web3_show_new_registration_page() {
			global $mo_web3_util;
			$mo_web3_util->mo_web3_update_option( 'mo_web3_new_registration', 'true' );
			$current_user = wp_get_current_user();
			?>
			<!--Register with miniOrange-->
			<form name="f" method="post" action="">
				<input type="hidden" name="option" value="mo_web3_register_customer" />
				<?php wp_nonce_field( 'mo_web3_register_customer', 'mo_web3_register_customer_nonce' ); ?>
				<div class="mo_table_layout">
					<div id="toggle1" class="panel_toggle">
						<h3>Register with miniOrange</h3>
					</div>
					<div id="panel1">
						<table class="mo_settings_table">

							<tr>
								<td><strong><span class="mo_premium_feature">*</span>Email:</strong></td>
								<td><input class="mo_table_textbox" type="email" name="email"
									required placeholder="person@example.com"
									value="<?php echo esc_attr( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' ) ); ?>" />
								</td>
							</tr>

							<tr class="hidden">
								<td><strong><span class="mo_premium_feature">*</span>Website/Company Name:</strong></td>
								<td><input class="mo_table_textbox" type="text" name="company"
								required placeholder="Enter website or company name"
								value="<?php echo esc_attr( isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '' ); ?>"/></td>
							</tr>

							<tr  class="hidden">
								<td><strong>&nbsp;&nbsp;First Name:</strong></td>
								<td><input class="mo_openid_table_textbox" type="text" name="fname"
								placeholder="Enter first name" value="<?php echo esc_attr( $current_user->user_firstname ); ?>" /></td>
							</tr>

							<tr class="hidden">
								<td><strong>&nbsp;&nbsp;Last Name:</strong></td>
								<td><input class="mo_openid_table_textbox" type="text" name="lname"
								placeholder="Enter last name" value="<?php echo esc_attr( $current_user->user_lastname ); ?>?>" /></td>
							</tr>

							<tr  class="hidden">
								<td><strong>&nbsp;&nbsp;Phone number :</strong></td>
								<td><input class="mo_table_textbox" type="text" name="phone" pattern="[\+]?([0-9]{1,4})?\s?([0-9]{7,12})?" id="phone" title="Phone with country code eg. +1xxxxxxxxxx" placeholder="Phone with country code eg. +1xxxxxxxxxx" value="<?php echo esc_attr( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_phone' ) ); ?>" />
								This is an optional field. We will contact you only if you need support.</td>
							</tr>						
							<tr  class="hidden">
								<td></td>
								<td>We will call only if you need support.</td>
							</tr>						
							<tr>
								<td><strong><span class="mo_premium_feature">*</span>Password:</strong></td>
								<td><input class="mo_table_textbox" required type="password"
									name="password" placeholder="Choose your password (Min. length 8)" /></td>
							</tr>

							<tr>
								<td><strong><span class="mo_premium_feature">*</span>Confirm Password:</strong></td>
								<td><input class="mo_table_textbox" required type="password"
									name="confirmPassword" placeholder="Confirm your password" /></td>
							</tr>

							<tr>
								<td>&nbsp;</td>
								<td><br /><input type="submit" name="submit" value="Register"
									class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" name="mo_web3_goto_login" id="mo_web3_goto_login" value="Already have an account?" class="button button-primary button-large"/>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</form>
			<form name="f1" method="post" action="" id="mo_web3_goto_login_form">
			<?php wp_nonce_field( 'mo_web3_goto_login_form', 'mo_web3_goto_login_form_field' ); ?>
			<input type="hidden" name="option" value="mo_web3_goto_login"/>
			</form>
			<script>
				jQuery("#phone").intlTelInput();
				jQuery('#mo_web3_goto_login').click(function () {
				jQuery('#mo_web3_goto_login_form').submit();
			} );
			</script>
			<?php
		}

		/**
		 * Function to render login UI.
		 */
		public function verify_password_ui() {
			global $mo_web3_util;
			?>
			<form name="f" method="post" action="">
				<input type="hidden" name="option" value="mo_web3_verify_customer" />
				<?php wp_nonce_field( 'mo_web3_verify_customer', 'mo_web3_verify_customer_nonce' ); ?>
				<div class="mo_table_layout">
					<div id="toggle1" class="mo_panel_toggle">
						<h3>Login with miniOrange</h3>
					</div>
					<p><strong>Please enter your miniOrange email and password.<br><a href="#mo_web3_forgot_password_link">Click here if you forgot your password</a></strong></p>

					<div id="panel1">
						</p>
						<table class="mo_settings_table">
							<tr>
								<td><strong><span class="mo_premium_feature">*</span>Email:</strong></td>
								<td><input class="mo_table_textbox" type="email" name="email"
									required placeholder="person@example.com"
									value="<?php echo esc_attr( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' ) ); ?>" /></td>
							</tr>
							<td><strong><span class="mo_premium_feature">*</span>Password:</strong></td>
							<td><input class="mo_table_textbox" required type="password"
								name="password" placeholder="Choose your password" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" name="submit"
									class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</form>
								
									<input type="button" name="back-button" onclick="document.getElementById('mo_web3_change_email_form').submit();" value="Sign up" class="button button-primary button-large">
								</td>
							</tr>
						</table>
					</div>
				</div>
			</form>
		<form id="mo_web3_change_email_form" method="post" action="">
			<input type="hidden" name="option" value="mo_web3_change_email" />
			<?php wp_nonce_field( 'mo_web3_change_email', 'mo_web3_change_email_nonce' ); ?>
		</form>
			<script>
				jQuery("a[href=\"#mo_web3_forgot_password_link\"]").click(function(){
					window.open('https://login.xecurify.com/moas/idp/resetpassword');
				});
			</script>

			<?php
		}



		/**
		 * Function to show customer info.
		 */
		public function show_customer_info() {
			global $mo_web3_util;
			?>
			<div class="mo_table_layout" >
				<h2>Thank you for registering with miniOrange.</h2>
				<table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:85%">
				<tr>
					<td style="width:45%; padding: 10px;">miniOrange Account Email</td>
					<td style="width:55%; padding: 10px;"><?php echo wp_kses( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_email' ), \mo_web3_get_valid_html() ); ?></td>
				</tr>
				<tr>
					<td style="width:45%; padding: 10px;">Customer ID</td>
					<td style="width:55%; padding: 10px;"><?php echo wp_kses( $mo_web3_util->mo_web3_get_option( 'mo_web3_admin_customer_key' ), \mo_web3_get_valid_html() ); ?></td>
				</tr>
				</table>
				<br /><br />

			<table>
			<tr>
			<td>
			<form name="f1" method="post" action="" id="mo_web3_goto_login_form">
				<input type="hidden" value="mo_web3_change_miniorange" name="option"/>
				<?php wp_nonce_field( 'mo_web3_change_miniorange', 'mo_web3_change_miniorange_nonce' ); ?>
				<input type="submit" value="Change Account" class="button button-primary button-large"/>
			</form>
			</td>
			</tr>
			</table>
			<br />
			</div>
			<?php
		}
	}

}

?>
