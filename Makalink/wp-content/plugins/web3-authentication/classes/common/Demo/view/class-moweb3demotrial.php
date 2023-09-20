<?php
/**
 * Core
 *
 * Create MoWeb3 Demo Trial View.
 *
 * @category   Common, Core
 * @package    MoWeb3\Demo\view\DemoTrialView;
 * @author     miniOrange <info@xecurify.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @link       https://miniorange.com
 */

namespace MoWeb3\Demo\view\DemoTrialView;

use MoWeb3\view\ButtonView\MoWeb3View;
use MoWeb3\view\AddOnsView\MoWeb3AddOns;

if ( ! class_exists( 'MoWeb3\Demo\view\DemoTrialView\MoWeb3DemoTrial' ) ) {
	/**
	 *  Demo Trial view
	 */
	class MoWeb3DemoTrial {
		/**
		 * Instance Util
		 *
		 * @var $util
		 * */
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
		 * View of Demo Trial tab
		 */
		public function view() {
			global $mo_web3_util;
			$date_today          = gmdate( 'F j, Y' );
			$expiry_date         = gmdate( 'F j, Y', strtotime( $date_today . ' + 7 days' ) );
			$demosite_trial_info = $mo_web3_util->mo_web3_get_option( 'mo_web3_demosite_trial_info' );
			$demo_plan           = isset( $demosite_trial_info->demo_plan[0] ) ? $demosite_trial_info->demo_plan[0] : '';
			if ( false !== $demosite_trial_info ) {
				?>
				<div>
					<div class="mo_support_layout container prem-info moweb3-demo-trial-container"  id="">

						<div class="col-sm-12">
							<h3 style="padding:0.5rem;">Demo Trial Credentials</h3>
						</div>

						<p style="color:gray;">You have successfully availed the trial for the chosen featured plugin. Please find the details below.</p>

						<div class="moweb3-demo-creds-table">
							<table style="width:100%;">
								<colgroup>
									<col style="width:40%;"/>
								</colgroup>
								<tr>
									<td class="moweb3-demo-cred-row"><label for="site_url">Demo Plan</label></td>
									<td><text style="color:gray;"><?php echo esc_attr( $demo_plan ); ?></text></td>
								</tr>
								<?php
								if ( isset( $demosite_trial_info->add_ons ) ) {
									$add_ons = explode( ',', $demosite_trial_info->add_ons );
									?>
									<tr>
									<td class="moweb3-demo-cred-row"><label for="site_url">Add Ons</label></td>
									<td>
										<ul class="moweb3-padding-0">
									<?php
									foreach ( $add_ons as $add_on ) {
										$add_on = explode( '@', $add_on );
										if ( isset( $add_on[0] ) ) {
											?>
											<li style="color:gray;"><?php echo esc_attr( $add_on[0] ); ?></li>
											<?php
										}
									}
									?>
										</ul>
									</td>
									</tr>
									<?php
								}
								?>
								<tr>
									<td class="moweb3-demo-cred-row"><label for="site_url">Site URL</label></td>
									<td><a href="<?php echo esc_attr( $demosite_trial_info->site_url ); ?>"  target="_blank">[ Click here ]</a></td>
								</tr>
								<tr >
									<td class="moweb3-demo-cred-row"><label for="username">Username</label></td>
									<td><text style="color:gray;"><?php echo esc_attr( $demosite_trial_info->email ); ?></text></td>
								</tr>
								<tr>
									<td class="moweb3-demo-cred-row"><label for="password">Password</label></td>
									<td><text style="color:gray;"><?php echo esc_attr( $demosite_trial_info->temporary_password ); ?></text></td>
								</tr>
								<tr>
									<td class="moweb3-demo-cred-row"><label for="password">Valid Till</label></td>
									<td><text style="color:gray;"><?php echo esc_attr( $expiry_date ); ?></text></td>
								</tr>
							</table>
							<p class="moweb3-demo-cred-row">You can reset password using <a href="<?php echo esc_attr( $demosite_trial_info->password_link ); ?>" target="_blank">this</a>  link.</p>
						</div>

						<br/>

						<p><strong style="color:blue;">Note :</strong> You must have received an email as well for these credentials to access this trial</p>

						<p>Also if you face any issues or still not convinced with this trial, don't hesitate to contact us at <a href="">web3@xecurify.com</a></p>

					</div>
				</div>

				<?php
			} else {
				?>
		<div>
			<div class="mo_support_layout container prem-info mt-3 moweb3-demo-trial-container"  id="mo_web3_demo_trial_form">
				<div class="container">
				<form method="post" action="">
					<input type="hidden" name="option" value="mo_auto_create_demosite" />
					<?php wp_nonce_field( 'mo_web3_demo_request_form', 'mo_web3_demo_request_form_nonce' ); ?>
					<div class="row jumbotron box8">
						<div class="col-sm-12" >
							<h3 class="mt-2 mb-2" style="">Demo Trial Request</h3>
						</div>

						<p style="color:gray;margin-top:15px;">Want to try out the paid features before purchasing the license? Just let us know which plan you're interested in and we will setup a demo for you.</p>

						<div class="col-sm-6 form-group mb-1">
							<label for="email" class="moweb3-demo-label">Email<span class="moweb3-text-red"> *</span></label>
							<input type="email" class="form-control" id="email" name="mo_web3_demo_email" required>
						</div>

						<div class="col-sm-6 form-group mb-1">
							<label for="CompanyName" class="moweb3-demo-label">Select the Plan you are interested in (Optional)</label>
							<select required name="mo_web3_demo_plan" id="mo_web3_demo_plan_id" class="form-control" >
								<option value="miniorange-web3-authentication-all-inclusive@13.0.0" selected>WP WEB3 Authentication All-Inclusive Plan</option>
								<option value="miniorange-web3-authentication-enterprise@12.0.0" >WP WEB3 Authentication Enterprise Plan</option>
								<option value="miniorange-web3-authentication-premium@11.0.0" >WP WEB3 Authentication Premium Plan</option>
								<option value="miniorange-web3-authentication-standard@10.0.0" >WP WEB3 Authentication Standard Plan</option>
							</select>
						</div>

						<div class="col-sm-6 form-group mb-1">
							<label for="Blockchain" class="moweb3-demo-label">Blockchain<span class="moweb3-text-red"> *</span></label>
							<input type="text" class="form-control" name="mo_web3_demo_blockchain" required>
						</div>

						<div class="col-sm-6 form-group mb-1">
							<label for="Crypto Wallet" class="moweb3-demo-label">Crypto Wallet<span class="moweb3-text-red"> *</span></label>
							<input type="text" class="form-control" name="mo_web3_demo_cryptowallet" required>
						</div>						
					</div>

					<div class="col-sm form-group mb-1">
							<label for="AddOns" class="moweb3-demo-label">Add Ons</label>
							<p class="text-primary">All-Inclusive Plan includes add-Ons for free; For all other plans, you would need to purchase add-ons separately</p>
							<?php
							foreach ( MoWeb3AddOns::$add_ons as $add_on ) {
								foreach ( $add_on['guide'] as $add_on => $properties ) {
									?>
										<input type="checkbox" id="<?php echo esc_attr( $properties['demosite_request'] ); ?>" name="<?php echo esc_attr( $properties['demosite_request'] ); ?>" value="<?php echo esc_attr( $properties['addon_folder'] ); ?>">
										<label><?php echo esc_attr( $add_on ); ?></label><br>
										<?php
								}
							}
							?>
					</div>

					<div class="col-sm form-group mb-1">
							<label for="Sample NFT URL" class="moweb3-demo-label">Sample NFT Collection URL</label>
							<input type="text" class="form-control" name="mo_web3_demo_nft_collection_url">
					</div>

					<div class="col-sm form-group mb-3">
						<label for="Use Case" class="moweb3-demo-label">Use Case<span class="moweb3-text-red"> *</span></label>
						<textarea type="text" class="form-control" minlength="15" name="mo_web3_demo_usecase" rows="4" placeholder="Write us about your usecase" required value=""></textarea>
					</div>


					<div class="col-sm-12 form-group mb-3">
						<input type="submit" class="" name="submit" class="button button-primary button-large " style="padding-top:0.375rem;padding-bottom:0.375rem;padding-right:2rem;padding-left:2rem;background: #2271b1;border-color: #2271b1;color: #fff;border-radius:3px !important;"/>
					</div>
				</form>
				</div>
			</div>

				<?php
			}
			?>

			<?php

		}

	}
}

?>
