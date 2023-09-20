<?php

namespace WordThree\Metamask;

use WordThree\Metamask\Pro\MetamaskPro;

class Metamask {
	/**
	 * Instance of this class
	 *
	 * @var Metamask|null
	 */
	private static $instance = null;

	/**
	 * Metamask constructor.
	 */
	private function __construct() {
		/**
		 * Enqueue scripts
		 */
		add_action('login_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);

		/**
		 * Popup modal in footer
		 */
		add_action('login_footer', [$this, 'popup_modal']);
		add_action('wp_footer', [$this, 'popup_modal']);

		/**
		 * Add rest api routes
		 */
		RestRoutes::instance();

		/**
		 * Add shortcodes
		 */
		Shortcodes::instance();

		/**
		 * Admin settings
		 */
		AdminSettings::instance();

		/**
		 * Menu customizer
		 * Adds login via metamask button in menu
		 */
		MenuCustomizer::instance();

		if (class_exists(MetamaskPro::class)) {
			MetamaskPro::instance();
		}
	}

	/**
	 * Instance of the class
	 *
	 * @return Metamask|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Enqueue scripts and styles
	 * And js localized values, text translation for js
	 */
	public function enqueue_scripts() {
		wp_enqueue_style('wordthree-metamask-login-style', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/css/main.css', [], WORDTHREE_METAMASK_PLUGIN_VERSION);
		wp_enqueue_script('wordthree-web3', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/js/web3.min.js', [], WORDTHREE_METAMASK_PLUGIN_VERSION, true);
		wp_enqueue_script('wordthree-metamask-popup', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/js/popup-modal.js', [], WORDTHREE_METAMASK_PLUGIN_VERSION, true);
		wp_enqueue_script('wordthree-metamask', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/js/metamask.js', ['wordthree-web3'], WORDTHREE_METAMASK_PLUGIN_VERSION, true);
		wp_enqueue_script('wordthree-metamask-login', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/js/metamask-login.js', ['wordthree-metamask-popup'], WORDTHREE_METAMASK_PLUGIN_VERSION, true);
		$localizedValues = static::localizedValues();
		if (class_exists(MetamaskPro::class)) {
			$localizedValues = array_merge($localizedValues, MetamaskPro::localizedValues());
		}
		wp_localize_script('wordthree-web3', 'wordthree', $localizedValues);
	}

	public static function localizedValues() {
		return [
			'translations' => [
				'yes' => __('Yes', 'wordthree'),
				'cancel' => __('Cancel', 'wordthree'),
				'ok' => __('Ok', 'wordthree'),
				'metamask_required_login' => __('MetaMask browser extension should be installed in order to use the login.', 'wordthree'),
				'install_now' => __('Install Now', 'wordthree'),
			],
			'nonce' => wp_create_nonce('wp_rest'),
			'apiUrl' => get_rest_url(),
			'restRoutes' => [
				'tokenUrl' => RestRoutes::REST_ROUTE_NAMESPACE . '/generate-nonce',
				'loginUrl' => RestRoutes::REST_ROUTE_NAMESPACE . '/login',
				'registerUrl' => RestRoutes::REST_ROUTE_NAMESPACE . '/register',
				'unlinkUrl' => RestRoutes::REST_ROUTE_NAMESPACE . '/unlink',
				'linkUrl' => RestRoutes::REST_ROUTE_NAMESPACE . '/link',
			]
		];
	}

	/**
	 * Enqueue admin scripts and styles
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style('wordthree-metamask-style', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/css/admin.css', [], WORDTHREE_METAMASK_PLUGIN_VERSION);
		wp_enqueue_script('wordthree-admin', WORDTHREE_METAMASK_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], WORDTHREE_METAMASK_PLUGIN_VERSION, true);
	}

	/**
	 * Popup modal view
	 * Loaded in footer
	 */
	public function popup_modal() {
		include_once WORDTHREE_METAMASK_PLUGIN_PATH . 'views/popup.php';
	}
}
