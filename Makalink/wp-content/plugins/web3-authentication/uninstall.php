<?php
/**
 * Uninstall
 *
 * @package    uninstall
 * @author     miniOrange <info@miniorange.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option( 'mo_web3_host_name' );
delete_option( 'mo_web3_admin_email' );
delete_option( 'mo_web3_admin_phone' );
delete_option( 'mo_web3_verify_customer' );
delete_option( 'mo_web3_admin_customer_key' );
delete_option( 'mo_web3_admin_api_key' );
delete_option( 'mo_web3_customer_token' );
delete_option( 'mo_web3_new_customer' );
delete_option( 'mo_web3_message' );
delete_option( 'mo_web3_new_registration' );
delete_option( 'mo_web3_registration_status' );
delete_option( 'mo_web3_display_login_button' );
delete_option( 'mo_web3_nft_settings' );
delete_option( 'mo_web3_button_custom_text' );
delete_option( 'mo_web3_display_login_button' );
delete_option( 'mo_web3_display_multiple_button' );
delete_option( 'mo_web3_plugin_version' );
delete_option( 'mo_web3_demosite_trial_info' );


