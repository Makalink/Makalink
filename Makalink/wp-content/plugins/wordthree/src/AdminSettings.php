<?php


namespace WordThree\Metamask;

class AdminSettings {
	/**
	 * Instance of this class
	 *
	 * @var AdminSettings|null
	 */
	private static $instance = null;
	/**
	 * Setting Values
	 *
	 * @var false|mixed|array
	 */
	private $setting_values = [];

	public function __construct() {
		$this->setting_values = get_option('wordthree_option');
		if (!$this->setting_values) {
			$this->setting_values = [];
		}

		/**
		 * Register Admin menu
		 */
		add_action('admin_menu', array($this, 'register_admin_menus'));

		/**
		 * Register setting sections and fields
		 */
		add_action('admin_init', array($this, 'settings_page_init'));

		/**
		 * Apply default values before saving the options
		 */
		add_filter('pre_update_option_wordthree_option', [$this, 'set_default_values']);
	}

	/**
	 * Instance of this class
	 *
	 * @return AdminSettings|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Set default values before saving the option
	 * Callback function for pre_update_option_{$option} filter hook
	 *
	 * @param $value
	 * @return array|object|string
	 * @see update_option()
	 */
	public function set_default_values( $value) {
		$defaultValues = [
			'login_redirect' => '',
			'button_design' => 'large',
			'button_color' => 'light',
			'enable_metamask_login' => 'off',
			'enable_metamask_register' => 'off',
			'display_on_login_page' => 'off',
			'display_on_register_page' => 'off',
			'display_on_woocommerce_account_page' => 'off',
			'display_on_woocommerce_register_form' => 'off',
			'display_on_woocommerce_login_form' => 'off',
			'display_on_woocommerce_checkout_form' => 'off',
		];

		return wp_parse_args($value, $defaultValues);
	}

	/**
	 * Register Admin menu
	 */
	public function register_admin_menus() {
		add_menu_page(
			esc_html__('WordThree Settings', 'wordthree'),
			esc_html__('WordThree Settings', 'wordthree'),
			'manage_options',
			'wordthree-settings',
			[$this, 'admin_settings_page'],
			WORDTHREE_METAMASK_PLUGIN_URL . 'assets/icon/wordthree.png'
		);
	}

	/**
	 * Displays admin setting page
	 */
	public function admin_settings_page() {
		include_once WORDTHREE_METAMASK_PLUGIN_PATH . 'views/admin/settings.php';
	}

	/**
	 * Registers setting sections and fields
	 */
	public function settings_page_init() {
		register_setting(
			'wordthree_option_group', // option_group
			'wordthree_option' // option_name,
		);

		add_settings_section(
			'wordthree_setting_section_general', // id
			esc_html__('General Settings', 'wordthree'), // title
			null,
			'wordthree-settings' // page
		);

		add_settings_field(
			'login_redirect', // id
			esc_html__('Redirect after login', 'wordthree'), // title
			[$this, 'login_redirect_field'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_general' // section
		);

		add_settings_field(
			'enable_metamask_login', // id
			esc_html__('Enable login with metamask?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_general', // section
			[
				'name' => 'enable_metamask_login',
				'checked' => $this->enableLogin(),
			]
		);

		add_settings_field(
			'enable_metamask_register', // id
			esc_html__('Enable register with metamask?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_general', // section
			[
				'name' => 'enable_metamask_register',
				'checked' => $this->enableRegister(),
			]
		);

		add_settings_field(
			'enable_account_linking', // id
			esc_html__('Enable account linking with metamask?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_general', // section
			[
				'name' => 'enable_account_linking',
				'checked' => $this->enableLinking(),
			]
		);

		add_settings_field(
			'enable_account_unlinking', // id
			esc_html__('Enable account linking with metamask?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_general', // section
			[
				'name' => 'enable_account_unlinking',
				'checked' => $this->enableUnlinking(),
			]
		);

		add_settings_section(
			'wordthree_setting_section_design', // id
			esc_html__('Button Design', 'wordthree'), // title
			null,
			'wordthree-settings' // page
		);

		add_settings_field(
			'button_design', // id
			esc_html__('Choose Button Design', 'wordthree'), // title
			[$this, 'button_design_field'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_design' // section
		);

		add_settings_field(
			'button_color', // id
			esc_html__('Choose Button Color', 'wordthree'), // title
			[$this, 'button_color_field'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_design' // section
		);

		add_settings_section(
			'wordthree_setting_section_wordpress', // id
			esc_html__('WordPress', 'wordthree'), // title
			null,
			'wordthree-settings' // page
		);

		add_settings_field(
			'display_on_login_page', // id
			esc_html__('Display on WordPress Login page?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_wordpress', // section
			[
				'name' => 'display_on_login_page',
				'checked' => $this->displayOnWpLoginPage(),
			]
		);

		add_settings_field(
			'display_on_register_page', // id
			esc_html__('Display on WordPress Register page?', 'wordthree'), // title
			[$this, 'checkbox'], // callback
			'wordthree-settings', // page
			'wordthree_setting_section_wordpress', // section
			[
				'name' => 'display_on_register_page',
				'checked' => $this->displayOnWPRegisterPage(),
			]
		);

		if (class_exists(\WooCommerce::class)) {
			add_settings_section(
				'wordthree_setting_section_woocommerce', // id
				esc_html__('Woocommerce', 'wordthree'), // title
				null,
				'wordthree-settings' // page
			);

			add_settings_field(
				'display_on_woocommerce_account_page', // id
				esc_html__('Display on Woocommerce Account Page?', 'wordthree'), // title
				[$this, 'checkbox'], // callback
				'wordthree-settings', // page
				'wordthree_setting_section_woocommerce', // section
				[
					'name' => 'display_on_woocommerce_account_page',
					'checked' => $this->displayOnWoocommerceAccountPage(),
				]
			);

			add_settings_field(
				'display_on_woocommerce_register_form', // id
				esc_html__('Display on WooCommerce Register Form?', 'wordthree'), // title
				[$this, 'checkbox'], // callback
				'wordthree-settings', // page
				'wordthree_setting_section_woocommerce', // section
				[
					'name' => 'display_on_woocommerce_register_form',
					'checked' => $this->displayOnWoocommerceRegisterForm(),
				]
			);

			add_settings_field(
				'display_on_woocommerce_login_form', // id
				esc_html__('Display on WooCommerce Login Form?', 'wordthree'), // title
				[$this, 'checkbox'], // callback
				'wordthree-settings', // page
				'wordthree_setting_section_woocommerce', // section
				[
					'name' => 'display_on_woocommerce_login_form',
					'checked' => $this->displayOnWoocommerceLoginForm(),
				]
			);

			add_settings_field(
				'display_on_woocommerce_checkout_form', // id
				esc_html__('Display on Checkout Register Form?', 'wordthree'), // title
				[$this, 'checkbox'], // callback
				'wordthree-settings', // page
				'wordthree_setting_section_woocommerce', // section
				[
					'name' => 'display_on_woocommerce_checkout_form',
					'checked' => $this->displayOnWoocommerceCheckoutForm(),
				]
			);
		}

	}

	/**
	 * Redirect on login setting field
	 */
	public function login_redirect_field() {
		?>
		<input type="text" name="wordthree_option[login_redirect_url]" id="login_redirect"
			   value="<?php echo esc_url(isset($this->setting_values['login_redirect_url']) ? $this->setting_values['login_redirect_url'] : ''); ?>">
		<?php
	}

	/**
	 * Button design field
	 */
	public function button_design_field() {
		$design = $this->buttonDesign();
		?>
		<label id="radio-1" class="radio-design">
			<input type="radio" name="wordthree_option[button_design]" id="button_design"
				   value="large" <?php checked($design, 'large'); ?>>
			<?php esc_html_e('Large', 'wordthree'); ?>
		</label>
		<label id="radio-2" class="radio-design">
			<input type="radio" name="wordthree_option[button_design]" id="button_design"
				   value="compact" <?php checked($design, 'compact'); ?>>
			<?php esc_html_e('Compact', 'wordthree'); ?>
		</label>
		<?php
	}

	/**
	 * Button color field
	 */
	public function button_color_field() {
		$button_color = $this->buttonColor();
		?>
		<label id="button-color-1" class="radio-color">
			<input type="radio" name="wordthree_option[button_color]"
				   value="light" <?php checked($button_color, 'light'); ?>>
			<?php esc_html_e('Light', 'wordthree'); ?>
		</label>
		<label id="button-color-2" class="radio-color">
			<input type="radio" name="wordthree_option[button_color]"
				   value="dark" <?php checked($button_color, 'dark'); ?>>
			<?php esc_html_e('Dark', 'wordthree'); ?>
		</label>
		<?php
	}

	/**
	 * Checkbox field
	 *
	 * @param array $args
	 */
	public function checkbox( $args = []) {
		$checked = isset($args['checked']) ? esc_attr($args['checked']) : false;
		?>
		<input type="checkbox" name="wordthree_option[<?php echo esc_attr($args['name']); ?>]"
			   value="on" <?php checked($checked); ?>>
		<?php
	}

	/**
	 * Get Metamask Icon
	 *
	 * @return false|string
	 */
	public static function metaMaskIcon() {
		return file_get_contents(WORDTHREE_METAMASK_PLUGIN_PATH . 'assets/icon/metamask-icon.svg');
	}

	/**
	 * Get Metamask Icon Url
	 *
	 * @return string
	 */
	public static function metaMaskIconUrl() {
		return WORDTHREE_METAMASK_PLUGIN_URL . 'assets/icon/metamask-icon.svg';
	}

	public static function metaAttentionIconUrl() {
		return WORDTHREE_METAMASK_PLUGIN_URL . 'assets/icon/attention.svg';
	}

	/**
	 * Get redirect after login url
	 *
	 * @return mixed|string|void
	 */
	public function redirectUrl() {
		$redirectUrl = admin_url();
		if (isset($this->setting_values['login_redirect_url']) && !empty($this->setting_values['login_redirect_url'])) {
			$redirectUrl = $this->setting_values['login_redirect_url'];
		}

		return esc_url($redirectUrl);
	}

	/**
	 * Get button design
	 *
	 * @return mixed|string
	 */
	public function buttonDesign() {
		$design = 'large';
		if (isset($this->setting_values['button_design'])) {
			if ($this->setting_values['button_design']) {
				$design = $this->setting_values['button_design'];
			}
		}

		return $design;
	}

	/**
	 * Get button color
	 *
	 * @return mixed|string
	 */
	public function buttonColor() {
		$button_color = 'light';
		if (isset($this->setting_values['button_color'])) {
			if ($this->setting_values['button_color']) {
				$button_color = $this->setting_values['button_color'];
			}
		}

		return $button_color;
	}

	public function enableLogin() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['enable_metamask_login'])) {
			return true;
		}

		return 'on' == $this->setting_values['enable_metamask_login'];
	}

	public function enableRegister() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['enable_metamask_register'])) {
			return true;
		}

		return 'on' == $this->setting_values['enable_metamask_register'];
	}

	public function enableLinking() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['enable_account_linking'])) {
			return true;
		}

		return 'on' == $this->setting_values['enable_account_linking'];
	}

	public function enableUnlinking() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['enable_account_unlinking'])) {
			return true;
		}

		return 'on' == $this->setting_values['enable_account_unlinking'];
	}

	public function displayOnWPLoginPage() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_login_page'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_login_page'];
	}

	public function displayOnWPRegisterPage() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_register_page'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_register_page'];
	}

	public function displayOnWoocommerceAccountPage() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_woocommerce_account_page'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_woocommerce_account_page'];
	}

	public function displayOnWoocommerceRegisterForm() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_woocommerce_register_form'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_woocommerce_register_form'];
	}

	public function displayOnWoocommerceLoginForm() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_woocommerce_login_form'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_woocommerce_login_form'];
	}

	public function displayOnWoocommerceCheckoutForm() {
		/**
		 * Default is true if option is not saved in database yet
		 */
		if (!isset($this->setting_values['display_on_woocommerce_checkout_form'])) {
			return true;
		}

		return 'on' == $this->setting_values['display_on_woocommerce_checkout_form'];
	}
}
