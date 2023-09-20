<?php


namespace WordThree\Metamask\Shortcodes;

use WordThree\Metamask\AdminSettings;

class Register {
	/**
	 * Shortcode tag
	 *
	 * @var string
	 */
	const SHORTCODE_TAG = 'wordthree_metamask_register';

	/**
	 * Instance of this class
	 *
	 * @var Register|null
	 */
	private static $instance = null;

	/**
	 * Register constructor.
	 */
	private function __construct() {
		add_shortcode(static::SHORTCODE_TAG, [$this, 'render']);
		/**
		 * If display on register page is enabled
		 */
		if (AdminSettings::instance()->displayOnWPRegisterPage()) {
			add_action('register_form', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}

		/**
		 * If display on woocommerce register form is enabled
		 */
		if (AdminSettings::instance()->displayOnWoocommerceRegisterForm()) {
			add_action('woocommerce_register_form_end', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}

		/**
		 * If registration by metamask is enabled on woocommerce checkout form is enabled
		 */
		if (AdminSettings::instance()->displayOnWoocommerceCheckoutForm()) {
			add_action('woocommerce_after_checkout_registration_form', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}
	}

	/**
	 * Instance of the class
	 *
	 * @return Register|null
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
		 * Not necessary to display if user is logged in
		 */
		if (is_user_logged_in()) {
			return '';
		}

		/**
		 * Enable registration is disabled
		 */
		if (!AdminSettings::instance()->enableRegister()) {
			return '';
		}

		$redirectUrl  = AdminSettings::instance()->redirectUrl();
		$design       = AdminSettings::instance()->buttonDesign();
		$design_wrap  = ( 'compact' == $design ) ? $design . '-wrap' : 'large-wrap';
		$button_color = AdminSettings::instance()->buttonColor();
		$design_icon  = '<span class="icon-metamask ' . $design . '">' . AdminSettings::metaMaskIcon() . '</span>';
		return '<div class="wt-metamask-btn wt-metamask-login ' . $design_wrap . '"><button type="button" data-redirect-url="' . $redirectUrl . '" class="wordthree-metamask-btn wordthree-metamask-register ' . $button_color . '">' . $design_icon . esc_html__('Register Via Metamask', 'wordthree') . '</button></div>';
	}
}
