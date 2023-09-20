<?php


namespace WordThree\Metamask;

class RestRoutes {
	/**
	 * Namespace where the API endpoints reside
	 *
	 * @var string
	 */
	const REST_ROUTE_NAMESPACE = 'wordthree';

	/**
	 * Instance of this class
	 *
	 * @var RestRoutes|null
	 */
	private static $instance = null;

	/**
	 * RestRoutes constructor.
	 */
	private function __construct() {
		/**
		 * Initialize rest routes
		 */
		add_action('rest_api_init', [$this, 'registerRoutes']);
	}

	/**
	 * Instance of this class
	 *
	 * @return RestRoutes|null
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register rest routes
	 */
	public function registerRoutes() {
		/**
		 * Generate nonce rest route
		 */
		register_rest_route(static::REST_ROUTE_NAMESPACE, '/generate-nonce', array(
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'generate_nonce'],
			'permission_callback' => function ( $request) {
				return true;
			},
		));

		/**
		 * Login route
		 */
		register_rest_route(static::REST_ROUTE_NAMESPACE, '/login', array(
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'login_metamask'],
			'permission_callback' => function ( $request) {
				return !is_user_logged_in();
			},
		));

		/**
		 * Register route
		 */
		register_rest_route(static::REST_ROUTE_NAMESPACE, '/register', array(
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'register_metamask'],
			'permission_callback' => function ( $request) {
				return !is_user_logged_in();
			},
		));

		/**
		 * Link account to metamask route
		 */
		register_rest_route(static::REST_ROUTE_NAMESPACE, '/link', array(
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'link_account_with_metamask'],
			'permission_callback' => function ( $request) {
				return is_user_logged_in();
			},
		));

		/**
		 * Unlink account from metamask route
		 */
		register_rest_route(static::REST_ROUTE_NAMESPACE, '/unlink', array(
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'unlink_metamask'],
			'permission_callback' => function ( $request) {
				return is_user_logged_in();
			},
		));
	}

	/**
	 * Endpoint that generates the message for the user to sign inside their wallet.
	 *
	 * @param $request \WP_REST_Request
	 * @return \WP_REST_Response
	 * @throws \Exception
	 */
	public function generate_nonce( $request) {
		$address = $request->get_param('address');
		if (!$address) {
			return $this->create_response(__('Address is empty.', 'wordthree'), false);
		}

		$nonce = AuthManager::instance()->generate_nonce($address);
		if ($nonce) {
			return $this->create_response(sprintf(__(AuthManager::MESSAGE, 'wordthree'), $nonce), true, ['nonce' => $nonce]);
		}

		return $this->create_response(__('Failed Creating Nonce.'), false);
	}

	/**
	 * Endpoint for logging in a Wallet to an already existing WordPress account
	 * or create new account if account does not exist
	 *
	 * @param $request \WP_REST_Request
	 * @return \WP_REST_Response
	 */
	public function login_metamask( $request) {
		if (!AdminSettings::instance()->enableLogin()) {
			return static::create_response(__('Login via metamask is disabled', 'wordthree'), false, [], '403');
		}

		$authManager                = AuthManager::instance();
		$validSignatureVerification = $authManager->verify_request($request);
		if (!$validSignatureVerification) {
			return static::create_response(__('Signature Verification Failed', 'wordthree'), false);
		}

		if ($authManager->login_user($request->get_param('address'))) {
			return static::create_response(__('Login Successful', 'wordthree'), true);
		}
		return static::create_response(__('Login failed', 'wordthree'), false);
	}

	/**
	 * Endpoint for registering user using Wallet.
	 *
	 * @param $request \WP_REST_Request
	 * @return \WP_REST_Response
	 */
	public function register_metamask( $request) {
		if (!AdminSettings::instance()->enableRegister()) {
			return static::create_response(__('Register via metamask is disabled', 'wordthree'), false, [], '403');
		}

		$authManager                = AuthManager::instance();
		$validSignatureVerification = $authManager->verify_request($request);
		if (!$validSignatureVerification) {
			return static::create_response(__('Signature Verification Failed', 'wordthree'), false);
		}

		if ($authManager->checkAccountExists($request->get_param('address'))) {
			return static::create_response(__('Account already Exists', 'wordthree'), false);
		}

		if ($authManager->login_user($request->get_param('address'))) {
			return static::create_response(__('Registration Successful', 'wordthree'), true);
		}

		return static::create_response(__('Registration failed', 'wordthree'), false);
	}

	/**
	 * Endpoint for linking existing wp account with metamask.
	 *
	 * @param $request \WP_REST_Request
	 * @return \WP_REST_Response
	 */
	public function link_account_with_metamask( $request) {
		if (!AdminSettings::instance()->enableLinking()) {
			return static::create_response(__('Link account to metamask is disabled', 'wordthree'), false, [], '403');
		}

		$authManager                = AuthManager::instance();
		$validSignatureVerification = $authManager->verify_request($request);
		if (!$validSignatureVerification) {
			return static::create_response(__('Signature Verification Failed', 'wordthree'), false);
		}

		$checkLinked = $authManager->checkLinkedWithMetamask(get_current_user_id());
		if ($checkLinked) {
			return static::create_response(__('Account is already linked.', 'wordthree'), false);
		}
		/**
		 * Check if provided address is already used by another account
		 */
		$userByAddress = $authManager->get_user_by_address($request->get_param('address'));
		if ($userByAddress && get_current_user_id() !== $userByAddress->ID) {
			return static::create_response(__('This wallet address is already linked with another account.', 'wordthree'), false);
		}

		if ($authManager->link_account_to_metamask(get_current_user_id(), $request->get_param('address'))) {
			return static::create_response(__('Account Link successful', 'wordthree'), true);
		}

		return static::create_response(__('Account Link failed', 'wordthree'), false);
	}

	/**
	 * Endpoint for unlinking an account from metamask.
	 *
	 * @param $request \WP_REST_Request
	 * @return \WP_REST_Response
	 */
	public function unlink_metamask( $request) {
		if (!AdminSettings::instance()->enableUnlinking()) {
			return static::create_response(__('Unlink account with metamask is disabled', 'wordthree'), false, [], '403');
		}

		$authManager                = AuthManager::instance();
		$validSignatureVerification = $authManager->verify_request($request);
		if (!$validSignatureVerification) {
			return static::create_response(__('Signature Verification Failed', 'wordthree'), false);
		}

		if ($authManager->unlink_user($request->get_param('address'))) {
			return static::create_response(__('Unlink Successful', 'wordthree'), true);
		}

		return static::create_response(__('Error Unlinking Account', 'wordthree'), false);
	}

	/**
	 * Create a response to send
	 *
	 * @param boolean $success true or false
	 * @param string $message message to send
	 * @param int $status status code of the response
	 * @param array $data array of extra parameters to send with response
	 * @return \WP_REST_Response
	 */
	public static function create_response( $message, $success = true, $data = [], $status = 200) {
		return new \WP_REST_Response(
			array_merge([
				'success' => $success,
				'message' => $message,
			], $data), $status);
	}
}
