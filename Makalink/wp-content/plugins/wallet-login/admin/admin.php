<?php
/**
 * Adding Custom User Meta backend
 */
function wpwlc__manage_users_address( $columns ) {
    // $columns is a key/value array of column slugs and names
    $columns[ 'wpwlc_address' ] = 'Wallet Address';
 
    return $columns;
}
add_filter( 'manage_users_columns', 'wpwlc__manage_users_address', 10, 1 );
function wpwlc__manage_users_custom_column( $output, $column_key, $user_id ) {
    switch ( $column_key ) {
        case 'wpwlc_address':
            $value = get_user_meta( $user_id, 'wpwlc_address', true );
            return $value;
            break;
        default: break;
    }
    // if no column slug found, return default output value
    return $output;
}
function wpwlc__manage_users_balance( $columns ) {
    // $columns is a key/value array of column slugs and names
    $columns[ 'wpwlc_balance' ] = 'Wallet Balance';
    return $columns;
}
add_filter( 'manage_users_columns', 'wpwlc__manage_users_balance', 10, 1 );

add_action( 'manage_users_custom_column', 'wpwlc__manage_users_custom_column', 10, 3 );
function wpwlc__manage_users_custom_balance( $output, $column_key, $user_id ) {
    switch ( $column_key ) {
       case 'wpwlc_balance':
           $value = get_user_meta( $user_id, 'wpwlc_balance', true );
            return $value;
            break;
        default: break;
    }
    // if no column slug found, return default output value
    return $output;
}

add_action( 'manage_users_custom_column', 'wpwlc__manage_users_custom_balance', 10, 3 );


/**
 * Adding Option PAge
 */
class WalletConnect {
	private $wallet_connect_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wallet_connect_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'wallet_connect_page_init' ) );
	}

	public function wallet_connect_add_plugin_page() {
		add_menu_page(
			'Wallet Connect', // page_title
			'Wallet Connect', // menu_title
			'manage_options', // capability
			'wallet-connect', // menu_slug
			array( $this, 'wallet_connect_create_admin_page' ), // function
			'dashicons-money', // icon_url
			99 // position
		);
	}

	public function wallet_connect_create_admin_page() {
		$this->wallet_connect_options = get_option( 'wallet_connect_option_name' ); ?>

		<div class="wrap">
			<h2><?php esc_html_e("Wallet Connect",'wallet-login');?></h2>
			<p><?php esc_html_e("Wallet Connect Configuration",'wallet-login');?></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wallet_connect_option_group' );
					do_settings_sections( 'wallet-connect-admin' );
					submit_button();
				?>
			</form>

			
			
		</div>
	<?php }

	public function wallet_connect_page_init() {
		register_setting(
			'wallet_connect_option_group', // option_group
			'wallet_connect_option_name', // option_name
			array( $this, 'wallet_connect_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'wallet_connect_setting_section', // id
			'Settings', // title
			array( $this, 'wallet_connect_section_info' ), // callback
			'wallet-connect-admin' // page
		);

		add_settings_field(
			'fortmatic_rpcurl_0', // id
			'Fortmatic rpcURL', // title
			array( $this, 'fortmatic_rpcurl_0_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);

		add_settings_field(
			'fortmatic_chainid_1', // id
			'Fortmatic chainID', // title
			array( $this, 'fortmatic_chainid_1_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);

		add_settings_field(
			'fortmatic_key_2', // id
			'Fortmatic Key', // title
			array( $this, 'fortmatic_key_2_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);

		add_settings_field(
			'wallet_connect_infuraid_3', // id
			'Wallet Connect infuraId', // title
			array( $this, 'wallet_connect_infuraid_3_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);

		add_settings_field(
			'portis_id_4', // id
			'Portis ID', // title
			array( $this, 'portis_id_4_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);

		add_settings_field(
			'button_classes_5', // id
			'Button Classes', // title
			array( $this, 'button_classes_5_callback' ), // callback
			'wallet-connect-admin', // page
			'wallet_connect_setting_section' // section
		);
	}

	public function wallet_connect_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['fortmatic_rpcurl_0'] ) ) {
			$sanitary_values['fortmatic_rpcurl_0'] = sanitize_text_field( $input['fortmatic_rpcurl_0'] );
		}

		if ( isset( $input['fortmatic_chainid_1'] ) ) {
			$sanitary_values['fortmatic_chainid_1'] = sanitize_text_field( $input['fortmatic_chainid_1'] );
		}

		if ( isset( $input['fortmatic_key_2'] ) ) {
			$sanitary_values['fortmatic_key_2'] = sanitize_text_field( $input['fortmatic_key_2'] );
		}

		if ( isset( $input['wallet_connect_infuraid_3'] ) ) {
			$sanitary_values['wallet_connect_infuraid_3'] = sanitize_text_field( $input['wallet_connect_infuraid_3'] );
		}

		if ( isset( $input['portis_id_4'] ) ) {
			$sanitary_values['portis_id_4'] = sanitize_text_field( $input['portis_id_4'] );
		}

	

		if ( isset( $input['button_classes_5'] ) ) {
			$sanitary_values['button_classes_5'] = sanitize_text_field( $input['button_classes_5'] );
		}

		return $sanitary_values;
	}

	public function wallet_connect_section_info() {
		
	}

	public function fortmatic_rpcurl_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[fortmatic_rpcurl_0]" id="fortmatic_rpcurl_0" value="%s">',
			isset( $this->wallet_connect_options['fortmatic_rpcurl_0'] ) ? esc_attr( $this->wallet_connect_options['fortmatic_rpcurl_0']) : ''
		);
	}

	public function fortmatic_chainid_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[fortmatic_chainid_1]" id="fortmatic_chainid_1" value="%s">',
			isset( $this->wallet_connect_options['fortmatic_chainid_1'] ) ? esc_attr( $this->wallet_connect_options['fortmatic_chainid_1']) : ''
		);
	}

	public function fortmatic_key_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[fortmatic_key_2]" id="fortmatic_key_2" value="%s">',
			isset( $this->wallet_connect_options['fortmatic_key_2'] ) ? esc_attr( $this->wallet_connect_options['fortmatic_key_2']) : ''
		);
	}

	public function wallet_connect_infuraid_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[wallet_connect_infuraid_3]" id="wallet_connect_infuraid_3" value="%s">',
			isset( $this->wallet_connect_options['wallet_connect_infuraid_3'] ) ? esc_attr( $this->wallet_connect_options['wallet_connect_infuraid_3']) : ''
		);
	}

	public function portis_id_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[portis_id_4]" id="portis_id_4" value="%s">',
			isset( $this->wallet_connect_options['portis_id_4'] ) ? esc_attr( $this->wallet_connect_options['portis_id_4']) : ''
		);
	}

	public function button_classes_5_callback() {
		printf(
			'<input class="regular-text" type="text" name="wallet_connect_option_name[button_classes_5]" id="button_classes_5" value="%s">',
			isset( $this->wallet_connect_options['button_classes_5'] ) ? esc_attr( $this->wallet_connect_options['button_classes_5']) : ''
		);
	}

}
if ( is_admin() )
	$wallet_connect = new WalletConnect();

/* 
 * Retrieve this value with:
 * $wallet_connect_options = get_option( 'wallet_connect_option_name' ); // Array of All Options
 * $fortmatic_rpcurl_0 = $wallet_connect_options['fortmatic_rpcurl_0']; // Fortmatic rpcURL
 * $fortmatic_chainid_1 = $wallet_connect_options['fortmatic_chainid_1']; // Fortmatic chainID
 * $fortmatic_key_2 = $wallet_connect_options['fortmatic_key_2']; // Fortmatic Key
 * $wallet_connect_infuraid_3 = $wallet_connect_options['wallet_connect_infuraid_3']; // Wallet Connect infuraId
 * $portis_id_4 = $wallet_connect_options['portis_id_4']; // Portis ID
 * $button_classes_5 = $wallet_connect_options['button_classes_5']; // Button Classes
 */
