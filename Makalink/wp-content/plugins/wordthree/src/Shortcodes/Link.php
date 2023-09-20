<?php


namespace WordThree\Metamask\Shortcodes;

use WordThree\Metamask\AdminSettings;
use WordThree\Metamask\AuthManager;

class Link {
	/**
	 * Shortcode tag
	 *
	 * @var string
	 */
	const SHORTCODE_TAG = 'wordthree_metamask_link';

	/**
	 * Instance of the class or null
	 *
	 * @var Link|null
	 */
	private static $instance = null;

	/**
	 * Link constructor.
	 */
	private function __construct() {
		add_shortcode(static::SHORTCODE_TAG, [$this, 'render']);
		/**
		 * If display on woocommerce myaccount page
		 */
		if (AdminSettings::instance()->displayOnWoocommerceAccountPage()) {
			add_action('woocommerce_after_edit_account_form', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});

			add_action('woocommerce_after_my_account', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}
	}

	/**
	 * Instance of the class
	 *
	 * @return Link|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Render shortcode
	 *
	 * @return string
	 */
	public function render() {
		/**
		 * Not necessary to link or unlink logged out user
		 */
		if (!is_user_logged_in()) {
			return '';
		}

		$linked       = AuthManager::instance()->checkLinkedWithMetamask(get_current_user_id());
		$design       = AdminSettings::instance()->buttonDesign();
		$design_wrap  = ( 'compact' == $design ) ? $design . '-wrap' : 'large-wrap';
		$button_color = AdminSettings::instance()->buttonColor();

		$design_icon = '<span class="icon-metamask ' . $design . '">' . AdminSettings::metaMaskIcon() . '</span>';
		if (!$linked) {
			/**
			 * Link Account is disabled
			 */
			if (!AdminSettings::instance()->enableLinking()) {
				return '';
			}
			return '<div class="wt-metamask-btn wt-metamask-link ' . $design_wrap . '"><button type="button" class="wordthree-metamask-btn wordthree-metamask-link ' . $button_color . '">' . $design_icon . esc_html__('Link Account To Metamask', 'wordthree') . '</button></div>';
		}

		/**
		 * Unlinking is disabled
		 */
		if (!AdminSettings::instance()->enableUnlinking()) {
			return '';
		}
		return '<div class="wt-metamask-btn wt-metamask-unlink ' . $design_wrap . '"><button type="button" class="wordthree-metamask-btn wordthree-metamask-unlink ' . $button_color . '">' . $design_icon . esc_html__('Unlink Account With Metamask', 'wordthree') . '</button></div>';
	}
}
