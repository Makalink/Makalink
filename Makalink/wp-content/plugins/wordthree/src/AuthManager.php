<?php

namespace WordThree\Metamask;

class AuthManager {

	const MESSAGE = 'Sign this message to validate that you are the owner of the account. Nonce string: %s';

	/**
	 * Instance of this class
	 *
	 * @var AuthManager|null
	 */
	private static $instance = null;

	/**
	 * AuthManager constructor.
	 */
	public function __construct() {

	}

	/**
	 * Instance of the class
	 *
	 * @return AuthManager|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Generate and save nonce
	 *
	 * @param string $address
	 * @return false|string
	 * @throws \Exception
	 */
	public function generate_nonce( $address) {
		$nonce = bin2hex(random_bytes(5));

		if ($this->saveNonce($address, $nonce)) {
			return $nonce;
		}

		return false;
	}

	/**
	 * Save nonce
	 *
	 * @param string $address
	 * @param string $nonce
	 * @return bool|int
	 */
	public function saveNonce( $address, $nonce) {
		global $wpdb;
		$result = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'twothree_metamask_accounts WHERE account_address=%s', $address));
		if ($result) {
			return $this->updateNonce($address, $nonce);
		}

		return $wpdb->insert($wpdb->prefix . 'twothree_metamask_accounts', [
			'user_id' => -1,
			'account_address' => $address,
			'nonce' => $nonce,
		]);
	}

	/**
	 * Update Nonce
	 *
	 * @param string $address
	 * @param string $nonce
	 * @return bool
	 */
	public function updateNonce( $address, $nonce) {
		global $wpdb;
		if ($wpdb->update($wpdb->prefix . 'twothree_metamask_accounts',
			[
				'nonce' => $nonce
			],
			[
				'account_address' => $address
			])) {
			return true;
		}

		return false;
	}

	/**
	 * Helper function to check if the request contains required parameters.
	 *
	 * @param $request \WP_REST_Request
	 * @return bool
	 */
	public function verify_request( $request) {
		global $wpdb;
		$address = $request->get_param('address');
		$result  = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'twothree_metamask_accounts WHERE account_address = %s', $address));

		if ($result) {
			return VerifyPersonalSignature::verify(sprintf(__(self::MESSAGE), $result->nonce), $request->get_param('signature'), $request->get_param('address'));
		}
		return false;
	}

	/**
	 * Login User using provided wallet address
	 *
	 * @param string $address
	 * @return bool
	 */
	public function login_user( $address) {
		wp_clear_auth_cookie();
		$user = $this->get_user_by_address($address);
		if ($user) {
			$user_id = $user->ID;
			wp_set_current_user($user_id, $address);
			wp_set_auth_cookie($user_id);
			return true;
		}

		$createdUserID = $this->create_user($address);
		if ($createdUserID) {
			wp_set_current_user($createdUserID, $address);
			wp_set_auth_cookie($createdUserID);
			return true;
		}

		return false;
	}

	/**
	 * Create a new WordPress user account and link the address with the user id.
	 *
	 * @param $address string
	 * @return bool|int
	 */
	public function create_user( $address) {
		global $wpdb;
		/**
		 * Return user by login if user was already created using the wallet address
		 */
		$check = get_user_by('login', $address);
		if ($check) {
			$wpdb->update($wpdb->prefix . 'twothree_metamask_accounts',
				array(
					'user_id' => $check->ID,
				),
				[
					'account_address' => $address,
				]);
			return $check->ID;
		}

		$currentUser = wp_create_user($address, wp_generate_password(), null);

		if (!is_wp_error($currentUser)) {
			$wpdb->update($wpdb->prefix . 'twothree_metamask_accounts',
				array(
					'user_id' => $currentUser,
				),
				[
					'account_address' => $address,
				]);
			return $currentUser;
		}
		return false;
	}

	/**
	 * Check if user account already exists
	 *
	 * @param $address
	 * @return bool
	 */
	public function checkAccountExists( $address) {
		$userByAddress = $this->get_user_by_address($address);
		if ($userByAddress) {
			return true;
		}

		$check = get_user_by('login', $address);
		if ($check) {
			return true;
		}

		return false;
	}

	/**
	 * Link an existing WordPress user account to metamask
	 *
	 * @param int $userID
	 * @param string $address
	 * @return bool
	 */
	public function link_account_to_metamask( $userID, $address) {
		global $wpdb;

		return $wpdb->update($wpdb->prefix . 'twothree_metamask_accounts',
			array(
				'user_id' => $userID,
			),
			[
				'account_address' => $address,
			]);
	}

	/**
	 * Unlink a WordPress user account from metamask login
	 *
	 * @param string $address
	 * @return bool
	 */
	public function unlink_user( $address) {
		global $wpdb;
		$userByAddress = $this->get_user_by_address($address);
		if (!$userByAddress) {
			return true;
		}

		if ($wpdb->delete($wpdb->prefix . 'twothree_metamask_accounts',
			array(
				'user_id' => $userByAddress->ID
			))) {
			return true;
		}
		return false;
	}

	/**
	 * Get the WP_User by its wallet address.
	 *
	 * @param string $address
	 * @return false|\WP_User
	 */
	public function get_user_by_address( $address) {
		global $wpdb;
		$result = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'twothree_metamask_accounts WHERE account_address = %s', $address));
		if (!$result) {
			return false;
		}
		return get_user_by('id', $result->user_id);
	}

	/**
	 * Check if given user id is linked to metamask
	 * Returns false if not linked otherwise user metamask info
	 *
	 * @param int $userID
	 * @return array|false|object|\stdClass
	 *
	 */
	public function checkLinkedWithMetamask( $userID) {
		global $wpdb;
		$result = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'twothree_metamask_accounts WHERE user_id = %d', $userID));
		if (!$result) {
			return false;
		}

		return $result;
	}
}
