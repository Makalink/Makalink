<?php


namespace WordThree\Metamask\Shortcodes;

use WordThree\Metamask\AdminSettings;

class Login {
	/**
	 * Shortcode tag
	 *
	 * @var string
	 */
	const SHORTCODE_TAG = 'wordthree_metamask_login';

	/**
	 * Instance of the class
	 *
	 * @var Login|null
	 */
	private static $instance = null;

	/**
	 * Login constructor.
	 */
	private function __construct() {
		add_shortcode(static::SHORTCODE_TAG, [$this, 'render']);
		/**
		 * If display on wp login page is enabled
		 */
		if (AdminSettings::instance()->displayOnWPLoginPage()) {
			add_action('login_form', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}

		/**
		 * If display on login form is enabled
		 */
		if (AdminSettings::instance()->displayOnWoocommerceLoginForm()) {
			add_action('woocommerce_login_form_end', function () {
				echo do_shortcode('[' . static::SHORTCODE_TAG . ']');
			});
		}

	}

	/**
	 * Returns instance ot the class
	 *
	 * @return Login|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Render shortcode output
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
		 * Login by metamask is disabled
		 */
		if (!AdminSettings::instance()->enableLogin()) {
			return '';
		}

		$redirectUrl  = AdminSettings::instance()->redirectUrl();
		$design       = AdminSettings::instance()->buttonDesign();
		$design_wrap  = ( 'compact' == $design ) ? $design . '-wrap' : 'large-wrap';
		$button_color = AdminSettings::instance()->buttonColor();

		$design_icon = '<span class="icon-metamask ' . $design . '">' . AdminSettings::metaMaskIcon() . '</span>';
		return '<div class="wt-metamask-btn wt-metamask-login ' . $design_wrap . '"><button type="button" data-redirect-url="' . $redirectUrl . '" class="wordthree-metamask-btn wordthree-metamask-login ' . $button_color . '">' . $design_icon . esc_html__('Login Via Metamask', 'wordthree') . '</button></div>';
	}

}
