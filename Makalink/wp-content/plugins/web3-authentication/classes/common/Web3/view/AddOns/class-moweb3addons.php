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

namespace MoWeb3\view\AddOnsView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'MoWeb3\view\AddOnsView\MoWeb3AddOns' ) ) {

	/**
	 * Addons view
	 */
	class MoWeb3AddOns {


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
			if ( true === $this->util->is_developer_mode ) {
				wp_enqueue_style( 'mo_web3_custom_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'dev/styles.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			} else {
				wp_enqueue_style( 'mo_web3_custom_style', MOWEB3_URL . \MoWeb3Constants::WEB3_CSS_PATH . 'prod/styles.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			}
		}
		/**
		 * Array of add-ons list
		 *
		 * @var $add_ons
		 */
		public static $add_ons = array(
			'BuddyBoss'   => array(
				'image'       => 'buddyboss.png',
				'title'       => 'BuddyBoss Integration',
				'description' => 'Integrate user cryptowallet information obtained from web3 authentication plugin to  NFT Token Gate Profiles on BuddyBoss.',
				'height'      => '150px',
				'guide'       => array(
					'BuddyBoss Profile Mapping' => array(
						'info_url'          => '',
						'youtube_url'       => '',
						'addon_folder'      => 'miniorange-web3-buddypress-profile-type-integration@3.0.1',
						'demosite_request'  => 'demosite_buddyboss_profile_mapping',
					),
				),
			),
			'WooCommerce' => array(
				'image'       => 'woocommerce.png',
				'title'       => 'WooCommerce Integration',
				'description' => 'Based on the user information gathered by the web3 plugin, this provides WooCommerce Product and Coupon NFT Token Gating for Web3 users.',
				'height'      => '125px',
				'guide'       => array(
					'WooCommerce Product Gating' => array(
						'info_url'          => 'https://plugins.miniorange.com/woocommerce-product-gating-based-on-nft-token',
						'youtube_url'       => '',
						'addon_folder'      => 'miniorange-woocommerce-product-nft-gating@3.0.1',
						'demosite_request'  => 'demosite_woocommerce_product_mapping',
					),
					'WooCommerce Coupon Gating'  => array(
						'info_url'          => 'https://plugins.miniorange.com/woocommerce-coupon-discount-based-on-nft',
						'youtube_url'       => 'https://www.youtube.com/watch?v=Fpc38jsJDPY',
						'addon_folder'      => 'miniorange-woocommerce-coupon-mapping-integration@3.0.1',
						'demosite_request'  => 'demosite_woocommerce_coupon_mapping',
					),

				),

			),
			'MemberPress' => array(
				'image'       => 'memberpress.png',
				'title'       => 'MemberPress Integration',
				'description' => 'Based on the user information gathered by the web3 authentication plugin, this provides Membership NFT Token Gating for Web3 users.',
				'height'      => '150px',
				'guide'       => array(
					'Memberpress Membership Mapping' => array(
						'info_url'          => 'https://plugins.miniorange.com/membership-mapping-based-on-nfts',
						'youtube_url'       => '',
						'addon_folder'      => 'miniorange-web3-memberpress-integration@3.0.1',
						'demosite_request'  => 'demosite_memberpress_membership_mapping',
					),

				),
			),
			'BradMax'     => array(
				'image'       => 'bradmax.png',
				'title'       => 'BradMax Player Integration',
				'description' => 'Get Video Analytics for Web3 Users for videos hosted on Bradmax player.',
				'height'      => '150px',
				'guide'       => array(
					'BradMax User Analytics' => array(
						'info_url'          => '',
						'youtube_url'       => '',
						'addon_folder'      => 'miniorange-web3-bradmax-player-integration@3.0.1',
						'demosite_request'  => 'demosite_bradmax_user_analytics_mapping',
					),

				),
			),
			'LearnDash'   => array(
				'image'       => 'LearnDash.png',
				'title'       => 'LearnDash Integration',
				'description' => 'LearnDash is popular WordPress LMS plugin.This add-on will NFT Gate the users to LearnDash groups .',
				'height'      => '60px',
				'guide'       => array(
					'LearnDash Attribute Integration ' => array(
						'info_url'          => '',
						'youtube_url'       => '',
						'addon_folder'      => 'miniorange-learndash-course-type-integration@3.0.1',
						'demosite_request'  => 'demosite_learndash_course_mapping',
					),

				),
			),
		);
		/**
		 * Function to return a single addon card UI
		 */
		public function view_add_on_card() {

			foreach ( self::$add_ons as $add_on ) {
				?>
			<div class="card card-custom bg-white border-white border-0 custom-card-css">
				<div class="card-custom-avatar">
					<img height="<?php echo esc_attr( $add_on['height'] ); ?>" src="<?php echo esc_url( MOWEB3_URL ) . esc_url_raw( \MoWeb3Constants::WEB3_IMG_PATH . "{$add_on['image']}" ); ?>" alt="Avatar" />
				</div>
				<div class="custom-card-text">
					<div class="card-body addon-card-body">
						<h3 class="card-title"><?php echo esc_html( $add_on['title'] ); ?></h3>
						<p class="card-text" >
							<?php echo esc_html( $add_on['description'] ); ?>
						</p>
					</div>
					<div class="card-footer addon-card-footer">
						<?php
						foreach ( $add_on['guide'] as $guide_name => $guide_links ) {
							if ( $guide_links['info_url'] || $guide_links['youtube_url'] ) {
								echo esc_attr( $guide_name );
								echo '<div style="display:flex;flex-direction:row;margin:4px;justify-content:space-between;">';
								if ( '' !== $guide_links['info_url'] ) {
									?>
									<button class="addon-card-learn-more-button">
										<a href="<?php echo esc_url( $guide_links['info_url'] ); ?>"  target="_blank" class="addon-link">
											<div><span style="color:black;" class="dashicons dashicons-media-document"></span></div>
											<h7 style="margin-left:0px;">Setup Guide</h7>
										</a>
									</button>
									<?php
								}
								if ( '' !== $guide_links['youtube_url'] ) {
									?>
									<button class="addon-card-learn-more-button" >
										<a href="<?php echo esc_url( $guide_links['youtube_url'] ); ?>" target="_blank" class="addon-link">
											<div><span style="color:red;" class="dashicons dashicons-youtube"></span></div>
											<h7 style="margin-left:0px;">Youtube Guide</h7>
										</a>
									</button>
									<?php
								}
								echo '</div>';
							}
						}
						?>
					</div>
				</div>
			</div>

				<?php
			}
		}

		/**
		 * Function to load addons tab UI
		 */
		public function view() {
			?>
			<div class="mo_support_layout container prem-info" >
					<div style="display:grid;grid-template-columns: repeat(3, 1fr);">

						<?php
						$this->view_add_on_card();
						?>

					</div>             
			</div>
			<?php
		}
	}
}
?>
