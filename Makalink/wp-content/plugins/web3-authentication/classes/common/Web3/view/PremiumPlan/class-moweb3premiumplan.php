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

namespace MoWeb3\view\PremiumPlan;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\view\ButtonView\MoWeb3View;

if ( ! class_exists( 'MoWeb3\view\PremiumPlan\MoWeb3PremiumPlan' ) ) {

	/**
	 * Class to Create MoWeb3 Premium Plan Tab View.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\view\PremiumPlan
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3PremiumPlan {

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
		 * Licensing tab view
		 */
		public function view() {
			?><div class="mo_license_heading" style="display: flex;padding-bottom:7px;padding-top: 35px;width: 100%;gap :35%" id="nav-container">
			<div>
				<a href="<?php echo esc_url_raw( add_query_arg( array( 'tab' => 'config' ), ! empty( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '' ) ); ?>">
					<button id="Back-To-Plugin-Configuration" type="button" value="Back-To-Plugin-Configuration"
						class="button button-primary button-large"
						style="position:absolute;left:10px;background-color: #093553;">
						<span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span>
						Plugin Configuration
					</button>
				</a>
			</div>
			<div style="display:block;text-align:center;margin: 10px;">
				<h2 style="font-size:22px;text-align: center;float: left"><b>miniOrange Web3 Authentication</b></h2>
			</div>
		</div>
			<?php
			$this->show_licensing_page();
		}

		/**
		 * Pricing of different plans
		 */
		public static function license_plans_pricing() {
			return 'pricingStandard:149;pricingPremium:499;pricingEnterprise:649;pricingAllinclusive:999';
		}
				/**
				 * Array of details of pricing plans
				 */
		public function license_plans() {
			return array(
				'pricingStandard'     => array(
					'plan'        => 'STANDARD',
					'description' => 'Crypto Wallet Login Support;Auto Creation of Users',
					'plan_name'   => 'wp_oauth_web3_authentication_standard_plan',
					'features'    => array(
						'Login Button Shortcode'     => '',
						'Login Button Customization' => '',
						'Custom Redirect Post Login' => '',
						'Enable new user profile completion' => '',
					),
				),
				'pricingPremium'      => array(
					'plan'        => 'PREMIUM',
					'description' => 'Cold Wallet Support;NFT Gated Contents',
					'plan_name'   => 'wp_oauth_web3_authentication_premium_plan',
					'features'    => array(
						'Login Button Shortcode'     => '',
						'Login Button Customization' => '',
						'Custom Redirect Post Login' => '',
						'Enable new user profile completion' => '',
						'NFT Token gating'           => '',
						'Connect wallet to existing profile' => '',
					),
				),
				'pricingEnterprise'   => array(
					'plan'        => 'ENTERPRISE',
					'description' => 'Role Mapping with Smart Contracts;Developer Hooks',
					'plan_name'   => 'wp_oauth_web3_authentication_enterprise_plan',
					'features'    => array(
						'Login Button Shortcode'        => '',
						'Login Button Customization'    => '',
						'Custom Redirect Post Login'    => '',
						'Enable new user profile completion' => '',
						'NFT Token gating'              => '',
						'NFT Importer Shortcode'        => '',
						'Role Mapping'                  => '',
						'NFT token gated section of page/post' => '',
						'Disconnect Button'             => '',
						'Connect wallet to existing profile' => '',
						'Customize end user experience' => '',
					),
				),
				'pricingAllinclusive' => array(
					'plan'        => 'ALL-INCLUSIVE',
					'description' => 'All Enterprise Features;Add-ons Integrations',
					'plan_name'   => 'wp_oauth_web3_authentication_all_inclusive_plan',
					'features'    => array(
						'All Enterprise Features + Add-ons mentioned in this plan below' => '',
						'WooCommerce Coupon Gating AddOn'  => 'https://www.youtube.com/watch?v=Fpc38jsJDPY',
						'WooCommerce Product Gating AddOn' => 'https://www.youtube.com/watch?v=vnNS-i6_wpE',
						'MemberPress Web3 Integration Add-on' => 'https://www.youtube.com/watch?v=LqWNjyHxVk8',
						'Learndash Web3 Integration Add-on' => 'https://www.youtube.com/watch?v=jZO8fbgDtL4',
						'Buddyboss / BuddyPress Web3 Integration' => 'https://www.youtube.com/watch?v=S3OBh-duVHM',
						'Brandmax Web3 Integartion'        => '',
					),
				),
			);
		}

		/**
		 * Pricing Plan view
		 *
		 * @param string $plan plan name.
		 * @param array  $plan_details details of the plan.
		 */
		public function render_pricing_plan_ui( $plan, $plan_details ) {
			?>
			<div class="col-3 mowt-align-center individual-container">
				<div class="mow-licensing-plan card-body">
					<div class="mow-licensing-plan-header">
						<div class="mow-licensing-plan-price"><strong><?php echo esc_attr( $plan_details['plan'] ); ?></strong></div>
						<hr>
						<div class="mow-licensing-plan-name">
						<?php
							$description_array      = explode( ';', $plan_details['description'] );
							$description_array_size = count( $description_array ) - 1;
						foreach ( $description_array as $key => $value ) {
							echo esc_js( $value );
							echo '<br>';
							if ( $key < $description_array_size ) {
								echo '+';
							}
							echo '<br>';
						}
						?>
						</div>
						<script>
						createSelectOptions('<?php echo esc_js( $plan ); ?>');
						</script>
					</div>
					<button class="btn-block mo-web3-btn-block text-uppercase mow-lp-buy-btn" onclick="upgradeform('<?php echo esc_js( $plan_details['plan_name'] ); ?>')"><?php esc_html_e( 'Upgrade Now', 'web3-authentication' ); ?></button>
					<div class="mow-licensing-plan-feature-list">
						<ul>
						<?php
							$feature_list = $plan_details['features'];

						foreach ( $feature_list as $key => $value ) {
							echo '<li>';
							echo '<div style="display:flex;">';
							echo '&#9989;&emsp;' . esc_attr( $key ) . '';
							if ( $value ) {
								?>
									<a href="<?php echo esc_url( $value ); ?>" target="_blank" class="addon-link">
										<div><span style="color:red;" class="dashicons dashicons-youtube"></span></div>
									</a>
									<?php
							}
							echo '</div>';
							echo '</li>';
						}

						?>
						</ul>
					</div>
				</div>
				<br>
			</div>
			<?php
		}
		/**
		 * Licensing tab view
		 */
		public function show_licensing_page() {
			?>
			<div id="navbar" style="padding-left: 22%;padding-top: 1%"  >
				<b><a href="#licensing_plans" id="plans-section" class="navbar-links">Plans</a></b>
				<b><a href="#upgrade-steps" id="upgrade-section" class="navbar-links">Upgrade Steps</a></b>
				<b><a href="#payment-method" id="payment-section" class="navbar-links">Payment Methods</a></b>
			</div>
			<script>    

				window.onscroll = function() {moWeb3StickyNavbar()};
				var navbar = document.getElementById("navbar");
				var sticky = navbar.offsetTop;

				function moWeb3StickyNavbar() {
					if (window.pageYOffset >= sticky) {
						navbar.classList.add("sticky")
					} else {
						navbar.classList.remove("sticky");
					}
				}
				var selectArray = [];
				var pricing = '<?php echo esc_js( self::license_plans_pricing() ); ?>';
				pricing = pricing.split(';');
				for (let i = 0; i < pricing.length; i++) {
					price = pricing[i].split(':');
					selectArray.push(price[0]);
					selectArray[price[0]]= {1 : price[1]};
				}

				function createSelectOptions(elemId) {
						var selectPricingArray = selectArray[elemId];
						var selectElem = ' <div class="cd-price" id="flex-container"><div class="mo-web3-flex-value" style="color: #0E1D35;"><span class="cd-currency">$</span><span class="cd-value" id="standardID">' + selectArray[elemId]["1"] + '</span></div><div class="mo-web3-flex-policy" style="font-size:3rem;"><sup><a href="#licensing_policy" style="text-decoration: none;color:#7C8594;">*</a></sup></div></div>' + '</header> <!-- .cd-pricing-header --></a>' + '<label for="' + elemId + '" style="font-size:0.6em" >No. of instances:</label>';
						var selectElem = selectElem + ' <span style="display:inline;overflow: hidden;padding: 0px 4px 0px 6px;"><select required="true" onchange="changePricing(this)" id="' + elemId + '" name="' + elemId + '">';
						for (var instances = 1; instances < 6; instances++) {                     
							selectElem = selectElem + '<option value="' + instances + '" data-value="' + instances + '">' + instances  + ' </option>';
						}
						selectElem = selectElem + "</select></span>";
						return document.write(selectElem);
					}

					function createSelectWithSubsitesOptions(elemId) {
						var selectPricingArray = selectArray[elemId];
						var selectSubsitePricingArray = selectArray['subsiteIntances'];
						var selectElem = ' <div class="cd-price" id="flex-container"><div class="mo-web3-flex-value" style="color: #0E1D35;"><span class="cd-currency">$</span><span class="cd-value" id="standardID">' + selectArray[elemId]["1"] + '</span></div><div class="mo-web3-flex-policy" style="font-size:3rem;"><sup><a href="#licensing_policy" style="text-decoration: none;color:#7C8594;">*</a></sup></div></div>' + '</header> <!-- .cd-pricing-header --></a>' + '<footer class="cd-pricing-footer"><div style="display: inline-block;float: left;"><h4 class="instanceClass" style="margin-bottom:2px;">No. of instances:';
						var selectElem = selectElem + ' <select class="selectInstancesClass" required="true" onchange="changePricing(this)" id="' + elemId + '">';
						jQuery.each(selectPricingArray, function (instances, price) {
							selectElem = selectElem + '<option value="' + instances + '" data-value="' + instances + '">' + instances + ' </option>';
						})
						selectElem = selectElem + "</select></h3>";
						selectElem = selectElem + '<h3 class="instanceClass" stlye="padding-top:2px;" >No. of subsites:&nbsp&nbsp';
						selectElem = selectElem + '<select class="selectInstancesClass" required="true" onchange="changePricing(this)" id="' + elemId + '" name="' + elemId + '-subsite">';
						jQuery.each(selectSubsitePricingArray, function (instances, price) {
							selectElem = selectElem + '<option value="' + instances + '" data-value="' + instances + '">' + instances + ' </option>';
						})
						selectElem = selectElem + "</select></h3></div>";
						return document.write(selectElem);
					}

					function changePricing($this) {
						var discountedPrice = [1,.95,.90,.85,.80];
						var selectId = jQuery($this).attr("id");
						var e = document.getElementById(selectId);
						var strUser = e.options[e.selectedIndex].value;
						var strUserInstances = strUser != "UNLIMITED" ? strUser : 500;
						selectArrayElement = [];
						if (selectId == "pricingStandard") selectArrayElement = Math.round(selectArray.pricingStandard[1]*strUser*discountedPrice[strUser-1]);
						if (selectId == "pricingPremium") selectArrayElement = Math.round(selectArray.pricingPremium[1]*strUser*discountedPrice[strUser-1]);
						if (selectId == "pricingEnterprise") selectArrayElement = Math.round(selectArray.pricingEnterprise[1]*strUser*discountedPrice[strUser-1]);
						if (selectId == "pricingAllinclusive") selectArrayElement = Math.round(selectArray.pricingAllinclusive[1]*strUser*discountedPrice[strUser-1]);;
						jQuery("#" + selectId).parents("div.individual-container").find(".cd-value").text(selectArrayElement);
					}

			</script>
			
			<!-- Licensing Table -->
			<br>

			<div style="text-align: center;" id="licensing_plans" onmouseenter="onMouseEnter('plans-section', '3px solid #093553')" onmouseleave="onMouseEnter('plans-section', 'none')">
				<h1 style="display:block;">Choose From The Below Plans To Upgrade</h1>
			</div>	
			<div class="mo-web3-licensing-container" style="height: 100%;margin-bottom: 5%" onmouseenter="onMouseEnter('plans-section','3px solid #093553')" onmouseleave="onMouseEnter('plans-section', 'none')">
				<div class="container-fluid">
					<div class="row">
						<div class="col-6 mowt-align-right">
							&nbsp;
						</div>
						<div class="col-6 mowt-align-right">
							&nbsp;
						</div>
					</div>
					<div id="single-site-section">
						<div class="row justify-content-center mx-15">
						<?php
							$plans = $this->license_plans();
						foreach ( $plans as $plan => $plan_details ) {
							$this->render_pricing_plan_ui( $plan, $plan_details );
						}
						?>
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="licensing-notice" style="height: 400px; padding-top: 10px;" id="upgrade-steps">
				<div class="PricingCard-toggle web3-plan-title mul-dir-heading "  onmouseenter="onMouseEnter('upgrade-section', '3px solid #093553')" onmouseleave="onMouseEnter('upgrade-section', 'none')" style="padding-top: 1px;">
							<h2 class="mo-web3-h2">HOW TO UPGRADE TO PREMIUM</h2>
							<!-- <hr style="background-color:#17a2b8; width: 20%;height: 3px;border-width: 3px;"> -->
						</div> 
				<section class="section-steps"  id="section-steps" onmouseenter="onMouseEnter('upgrade-section', '3px solid #093553')" onmouseleave="onMouseEnter('upgrade-section', 'none')">
						<div class="row">
								<div class="col span-1-of-2 steps-box">
									<div class="works-step">
										<div><b>1</b></div>
										<p>
											Click on <b><i>Upgrade Now</i></b> button for required premium plan and you will be redirected to miniOrange login console.
										</p>
									</div>
									<div class="works-step">
										<div><b>2</b></div>
										<p>
											Enter your miniOrange account credentials. You can create one for free <i><b><a href="admin.php?page=mo_web3_settings&tab=account">here</a></b></i> if you don't have. Once you have successfuly logged in, you will be redirected towards the payment page. 
										</p>
									</div>
									<div class="works-step">
										<div><b>3</b></div>
										<p>
											Enter your card details and proceed for payment. On successful payment completion, the premium plugin will be available to download. 
										</p>
									</div>
									</div>
									<div class="col span-1-of-2 steps-box">
									<div class="works-step">
										<div><b>4</b></div>
										<p>
											You can download the premium plugin from the <b><i>Releases and Downloads</i></b> section on the miniOrange console.
										</p>
									</div>						
									<div class="works-step">
										<div><b>5</b></div>
										<p>
											From the WordPress admin dashboard, deactivate the free plugin currently installed.
										</p>
									</div>
									<div class="works-step">
										<br>
										<div><b>6</b></div>
										<p style="padding-top:10px;">
											Now install the downloaded premium plugin and activate it.
											After activating the premium plugin, login using the account which you have used for the purchase of premium license.<br> <br>
										</p>
									</div>
								</div>
							</div> 
							</section>
							</div> 

							<div class="licensing-notice" style="height: 10%px; padding-top: 10px;" >

								<div class="PricingCard-toggle ">
					<h2 class="mo-web3-h2"> INSTANCE - SUBSITES DEFINITION</h2>
				</div>
				<!-- <hr style="background-color:#17a2b8; width: 20%;height: 3px;border-width: 3px;"> -->
							<br>
							<div class="instance-subsites">
					<div class="row">
						<div class="col span-1-of-2 instance-box">
							<h3 class="myH3">What is an instance?</h3><br>
							<br><p style="font-size: 1em;">A WordPress instance refers to a single installation of a WordPress site. It refers to each individual website where the plugin is active. In the case of a single site WordPress, each website will be counted as a single instance.
							<br>
							<br> For example, You have 3 sites hosted like one each for development, staging, and production. This will be counted as 3 instances.</p>
						</div>
						<div class="col span-1-of-2 subsite-box">
							<h3 class="myH4">What is a multisite network?</h3><br>
							<br><p style="font-size: 1em;">A multisite network means managing multiple sites within the same WordPress installation and has the same database.
							<br>
							<br>For example, You have 1 WordPress instance/site with 3 subsites in it then it will be counted as 1 instance with 3 subsites.
							<br> You have 1 WordPress instance/site with 3 subsites and another WordPress instance/site with 2 subsites then it will be counted as 2 instances with 3 subsites.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="licensing-notice" id="payment-method" style="height: 10%;padding-top: 10px;min-height: 400px;" onmouseenter="onMouseEnter('payment-section', '3px solid #093553')" onmouseleave="onMouseEnter('payment-section', 'none')">
				<h2 class="mo-web3-h2">ACCEPTED PAYMENT METHODS</h2>
				<section class="payment-methods" style="height: 400px;" >
				<br>
				<div class="row">
					<div class="col span-1-of-3">
						<div class="plan-box">
							<div>
								<span style="font-size: 20px;font-weight:500;">&nbsp;&nbsp;Credit / Debit Card</span>
							</div>
							<div>
								If the payment is made through Credit Card/International Debit Card, the license will be created automatically once the payment is completed.
							</div>
						</div>
					</div>
					<div class="col span-1-of-3">
						<div class="plan-box">
							<div>
								<img class="payment-images" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'paypal.png'; ?>" alt="">
							</div>
							<div>
								Use the following PayPal ID <i><b>info@xecurify.com</b></i> for making the payment via PayPal.<br><br>
							</div>
						</div>
					</div>
					<div class="col span-1-of-3">
						<div class="plan-box">
							<div><span style="font-size: 20px;font-weight:500;">&nbsp;&nbsp;Bank Transfer</span>							  
							</div>
							<div>
								If you want to use bank transfer for the payment then contact us at <b><i><span>info@xecurify.com</span></i></b>  so that we can provide you the bank details.
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<p style="margin-top:20px;font-size:16px;">
						<span style="font-weight:500;"> Note :</span> Once you have paid through PayPal/Net Banking, please inform us so that we can confirm and update your license.
					</p>
				</div>
				</section>
			</div>
						<!-- Licensing Plans End -->
						<div class="licensing-notice" style="min-height:450px;">
							<h2 id="licensing_policy" class="mo-web3-h2">LICENSING POLICY</h2>
							<br>
							<p style="font-size: 1em;"><span style="color: red;">*</span>Cost applicable for one instance only. Licenses are perpetual and the Support Plan includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current license cost.<br></p>

							<p style="font-size: 1em;"><span style="color: red;">*</span>We provide deep discounts on bulk license purchases and pre-production environment licenses. As the no. of licenses increases, the discount percentage also increases. Contact us at <i><a href="">web3@xecurify.com</a></i> for more information.</p>

							<p style="font-size: 1em;"><span style="color: red;">*</span><strong>MultiSite Network Support : </strong>
								There is an additional cost for the number of subsites in Multisite Network. The Multisite licenses are based on the <b>total number of subsites</b> in your WordPress Network.
								<br>
								<br>
								<strong>Note</strong> : We do not provide the developer license for our paid plugins and the source code is protected. It is strictly prohibited to make any changes in the code without having written permission from miniOrange. There are hooks provided in the plugin which can be used by the developers to extend the plugin's functionality.
								<br>
								<br>
							At miniOrange, we want to ensure you are 100% happy with your purchase. For more details on our plugin licensing terms and refund policy, you can check out our<i><a href="https://plugins.miniorange.com/end-user-license-agreement" target="_blank"> End User License Agreement.</a></i> Please email us at <i><a href="mailto:info@xecurify.com" target="_blank">info@xecurify.com</a></i> for any queries regarding the return policy.</p>
						</div>

			<!-- End Licensing Table -->
			<a  id="mobacktoaccountsetup" style="display:none;" href="<?php echo esc_url( add_query_arg( array( 'tab' => 'account' ), ! empty( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '' ) ); ?>">Back</a>
			<!-- JSForms Controllers -->
			<script>  

				function upgradeform(planType) {
					if(planType === "") {
						location.href = "https://wordpress.org/plugins/web3-authentication/";
						return;
					} else {

						let customerRegistered	=	Number("<?php echo esc_attr( $this->util->mo_web3_is_customer_registered() ); ?>");
						if(1 ==customerRegistered){
							const url = `https://portal.miniorange.com/initializepayment?requestOrigin=${planType}`;
							window.open(url, "_blank");
						}
						else{
							location.href = jQuery('#mobacktoaccountsetup').attr('href');
						}
					}

				}
			</script>
			<script>

			function onMouseEnter(divid, css){
				document.getElementById(divid).style.borderBottom = css;		
			}
		</script>
			<!-- End JSForms Controllers -->
			<?php
		}
	}
}
?>
