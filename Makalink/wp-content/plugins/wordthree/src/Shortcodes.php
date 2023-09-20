<?php


namespace WordThree\Metamask;

use WordThree\Metamask\Shortcodes\Link;
use WordThree\Metamask\Shortcodes\Login;
use WordThree\Metamask\Shortcodes\Register;

class Shortcodes {

	/**
	 * Instance of this class
	 *
	 * @var Shortcodes|null
	 */
	private static $instance = null;

	/**
	 * Shortcodes constructor.
	 */
	private function __construct() {
		/**
		 * Initialize shortcodes
		 */

		/**
		 * Login shortcode
		 */
		Login::instance();

		/**
		 * Link Account shortcode
		 */
		Link::instance();

		/**
		 * Register Shortcode
		 */
		Register::instance();
	}

	/**
	 * Instance of the class
	 *
	 * @return Shortcodes|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
