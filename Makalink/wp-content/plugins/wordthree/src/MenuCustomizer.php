<?php


namespace WordThree\Metamask;

use WordThree\Metamask\Shortcodes\Login;

class MenuCustomizer {
	/**
	 * Instance of the class
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * MenuCustomizer constructor.
	 */
	private function __construct() {
		/**
		 * Add wordthree links meta box in menu edit page
		 */
		add_action('admin_head-nav-menus.php', [$this, 'add_nav_menu_meta_boxes']);

		/**
		 * Remove login link from menu if user is logged in
		 */
		add_filter('wp_nav_menu_objects', [$this, 'remove_login_by_metamask_for_logged_in_user']);

		/**
		 * Add custom menu item fields
		 */
		add_action('wp_nav_menu_item_custom_fields', [$this, 'add_custom_menu_item_fields'], 10, 2);

		/**
		 * Save custom menu item field data
		 */
		add_action('wp_update_nav_menu_item', [$this, 'save_custom_menu_item_data'], 10, 2);

		/**
		 * Add / remove wordthree-metamask-login class
		 */
		add_action('nav_menu_css_class', [$this, 'login_menu_item_css_classes'], 10, 2);

		/**
		 * Change output to button if display button option is chosen
		 */
		add_action('walker_nav_menu_start_el', [$this, 'show_login_button'], 10, 2);
	}

	/**
	 * Get instance of the class
	 *
	 * @return MenuCustomizer|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Displays custom menu item fields
	 *
	 * @param $item_id
	 * @param $item
	 */
	public function add_custom_menu_item_fields( $item_id, $item) {
		$isMetamaskLoginLink = ( 'yes' == get_post_meta($item_id, '_wordthree_menu_item_is_login_link', true) );
		if (wp_doing_ajax()) {
			$isMetamaskLoginLink = isset($item->classes) && is_array($item->classes) && in_array('wordthree-metamask-login', $item->classes);
		}

		if ($isMetamaskLoginLink) {
			$displayButton = ( 'on' == get_post_meta($item_id, '_wordthree_display_login_button', true) );
			?>
			<p class="field-wordthree-display-login-button description description-wide">
				<label for="edit-menu-item-wordthree-display-login-button-<?php echo esc_attr($item_id); ?>">
					<input type="hidden" name="wordthree-is-metamask-login[<?php echo esc_attr($item_id); ?>]"
						   value="yes">
					<input type="checkbox"
						   id="edit-menu-item-wordthree-display-login-button-<?php echo esc_attr($item_id); ?>"
						   value="on" <?php checked($displayButton); ?>
						   name="wordthree-display-login-button[<?php echo esc_attr($item_id); ?>]">
					<?php esc_html_e('Display Button instead of text', 'wordthree'); ?>
				</label>
			</p>
			<span class="description"><?php esc_html_e('If enabled, login button will be displayed instead of text', 'wordthree'); ?></span>
			<?php
		}
	}

	/**
	 * Saves custom menu item fields
	 *
	 * @param $menu_id
	 * @param $item_id
	 */
	public function save_custom_menu_item_data( $menu_id, $item_id) {
		$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : 'edit';
		switch ($action) {
			case 'add-menu-item':
				check_admin_referer('add-menu_item', 'menu-settings-column-nonce');
				break;
			case 'update':
				check_admin_referer('update-nav_menu', 'update-nav-menu-nonce');
				break;
			default:
				wp_nonce_ays($action);
				die();
		}

		$isMetamaskLoginLink = isset($_POST['wordthree-is-metamask-login'][$item_id]) && 'yes' == $_POST['wordthree-is-metamask-login'][$item_id];
		if ($isMetamaskLoginLink) {
			update_post_meta($item_id, '_wordthree_menu_item_is_login_link', 'yes');
			$displayButton = isset($_POST['wordthree-display-login-button'][$item_id]) && 'on' == $_POST['wordthree-display-login-button'][$item_id];
			if ($displayButton) {
				update_post_meta($item_id, '_wordthree_display_login_button', 'on');
			} else {
				delete_post_meta($item_id, '_wordthree_display_login_button', 'on');
			}
		} else {
			delete_post_meta($item_id, '_wordthree_menu_item_is_login_link');
		}
	}

	/**
	 * Add wordthree menu items meta box in nav menu settings page
	 */
	public function add_nav_menu_meta_boxes() {
		add_meta_box('wordthree_metamask_login_link', esc_html__('Wordthree', 'woocommerce'), [$this, 'nav_menu_links'], 'nav-menus', 'side', 'low');
	}

	/**
	 * Output menu links meta box in nav menu settings page
	 */
	public function nav_menu_links() {
		?>
		<div id="posttype-wordthree-endpoints" class="posttypediv">
			<div id="tabs-panel-wordthree-endpoints" class="tabs-panel tabs-panel-active">
				<ul id="wordthree-endpoints-checklist" class="categorychecklist form-no-clear">
					<li>
						<label class="menu-item-title">
							<input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]"
								   value="-1">
							<?php esc_html_e('Login via Metamask'); ?>
						</label>
						<input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom">
						<input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]"
							   value="<?php esc_attr_e('Login via Metamask'); ?>">
						<input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="#">
						<input type="hidden" class="menu-item-custom" name="menu-item[-1][menu-item-custom]"
							   value="metamask">
						<input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]"
							   value="wordthree-metamask-login">
					</li>
				</ul>
			</div>
			<p class="button-controls wp-clearfix" data-items-type="posttype-wordthree-endpoints">
				<span class="list-controls hide-if-no-js">
					<input type="checkbox" id="wordthree-endpoints-tab" class="select-all">
					<label for="wordthree-endpoints-tab"><?php esc_html_e('Select All', 'wordthree'); ?></label>
				</span>
				<span class="add-to-menu">
					<input type="submit" class="button submit-add-to-menu right"
						   value="<?php esc_attr_e('Add to Menu', 'wordthree'); ?>"
						   name="add-post-type-menu-item" id="submit-posttype-wordthree-endpoints">
					<span class="spinner"></span>
				</span>
			</p>
		</div>
		<?php
	}

	/**
	 * Add wordthree-metamask-login class if link is login by metamask link
	 * Removes the class if display button is chosen since the class already exist the button itself
	 * Note: Login button works only if wordthree-metamask-login class is added to a HTML element
	 *
	 * @param $classes
	 * @param $menu_item
	 * @return array
	 */
	public function login_menu_item_css_classes( $classes, $menu_item) {
		$isMetamaskLoginLink = ( 'yes' == get_post_meta($menu_item->ID, '_wordthree_menu_item_is_login_link', true) );
		if (!$isMetamaskLoginLink) {
			return array_diff($classes, ['wordthree-metamask-login']);
		}

		if (!in_array('wordthree-metamask-login', $classes)) {
			array_push($classes, 'wordthree-metamask-login');
		}

		$displayButton = ( 'on' == get_post_meta($menu_item->ID, '_wordthree_display_login_button', true) );
		if ($displayButton) {
			return array_diff($classes, ['wordthree-metamask-login']);
		}

		return $classes;
	}

	/**
	 * Display login button instead of text if display button option is chosen
	 *
	 * @param $item_output
	 * @param $menu_item
	 * @return string
	 */
	public function show_login_button( $item_output, $menu_item) {
		$isMetamaskLoginLink = ( 'yes' == get_post_meta($menu_item->ID, '_wordthree_menu_item_is_login_link', true) );
		if (!$isMetamaskLoginLink) {
			return $item_output;
		}
		$displayButton = ( 'on' == get_post_meta($menu_item->ID, '_wordthree_display_login_button', true) );
		if ($displayButton) {
			return do_shortcode('[' . Login::SHORTCODE_TAG . ']');
		}
		return $item_output;
	}

	/**
	 * Removes login menu item for logged in users
	 *
	 * @param $menu_items
	 * @return array
	 */
	public function remove_login_by_metamask_for_logged_in_user( $menu_items) {
		if (!is_user_logged_in()) {
			return $menu_items;
		}

		$loginMetamaskItems = array_filter($menu_items, function ( $menuItem) {
			$isMetamaskLoginLink = ( 'yes' == get_post_meta($menuItem->ID, '_wordthree_menu_item_is_login_link', true) );
			if ($isMetamaskLoginLink) {
				return in_array('wordthree-metamask-login', $menuItem->classes);
			}
			return false;
		});

		if (!empty($loginMetamaskItems)) {
			return array_diff_key($menu_items, $loginMetamaskItems);
		}

		return $menu_items;
	}
}
