<?php
/**
 * Plugin Name: Wallet Login
 * Plugin URI: https://gigsix.com/
 * Description: WP Wallet Login, Login with Crypto Wallets.
 * Author: alisaleem252
 * Version: 1.5.4
 * Author URI: https://gigsix.com
 * Text Domain: wallet-login
 * Domain Path: /languages
 *
 * @package wallet-login
 */
define('wpwlc_URL', plugin_dir_url(__FILE__));
define('wpwlc_PATH', dirname(__FILE__));

require_once wpwlc_PATH."/admin/admin.php";
require_once wpwlc_PATH."/public/hooks.php";
require_once wpwlc_PATH."/public/shortcode.php";
require_once wpwlc_PATH."/admin/page.php";



    if(function_exists("elementor_load_plugin_textdomain")){

        add_action( 'elementor/widgets/register', 'register_connect_wallet_custom_widgetsCBF' );
        function register_connect_wallet_custom_widgetsCBF( $widgets_manager ) {
            require_once( __DIR__ . '/public/elementor_element.php' );
            $widgets_manager->register( new \Connect_Wallet_Widget() );  

        }
    }



   	add_action( 'login_enqueue_scripts', 'wpwlc_enqueue_scriptsCBF',1 );
	add_action('wp_enqueue_scripts', 'wpwlc_enqueue_scriptsCBF',1);
	function wpwlc_enqueue_scriptsCBF(){
		wp_enqueue_script('web3-axios.min-JS', plugins_url('js/axios.min.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-web3.min-JS', plugins_url('js/web3.min.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-web3modal-JS', plugins_url('js/web3modal.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-portis-JS', plugins_url('js/portis.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-torus.min-JS', plugins_url('js/torus.min.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-fortmatic-JS', plugins_url('js/fortmatic.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-walletconnect.min-JS', plugins_url('js/walletconnect.min.js', __FILE__ ),array('jquery'));

       
		wp_enqueue_script('web3-login-custom-JS', plugins_url('js/web3-login.js', __FILE__ ),array('jquery'));
		wp_enqueue_script('web3-modal-custom-JS', plugins_url('js/web3-modal.js', __FILE__ ),array('jquery'));
		

		$wallet_connect_options = get_option( 'wallet_connect_option_name' ); // Array of All Options
		$fortmatic_rpcurl_0 = $wallet_connect_options['fortmatic_rpcurl_0']; // Fortmatic rpcURL
		$fortmatic_chainid_1 = $wallet_connect_options['fortmatic_chainid_1']; // Fortmatic chainID
		$fortmatic_key_2 = $wallet_connect_options['fortmatic_key_2']; // Fortmatic Key
		$wallet_connect_infuraid_3 = $wallet_connect_options['wallet_connect_infuraid_3']; // Wallet Connect infuraId
		$portis_id_4 = $wallet_connect_options['portis_id_4']; // Portis ID
	
	
		wp_add_inline_script( 'web3-modal-custom-JS','
			var ajaxurl = "'.admin_url( 'admin-ajax.php' ).'"; 
			var fortmatic_rpcurl_0 = "'.($fortmatic_rpcurl_0 && $fortmatic_rpcurl_0 != '' ? $fortmatic_rpcurl_0 : '').'";
			var fortmatic_chainid_1 = "'.($fortmatic_chainid_1 && $fortmatic_chainid_1 != '' ? $fortmatic_chainid_1 : '').'";
			var fortmatic_key_2 = "'.($fortmatic_key_2 && $fortmatic_key_2 != '' ? $fortmatic_key_2 : '').'";
			var wallet_connect_infuraid_3 = "'.($wallet_connect_infuraid_3 && $wallet_connect_infuraid_3 != '' ? $wallet_connect_infuraid_3 : '').'";
			var portis_id_4 = "'.($portis_id_4 && $portis_id_4 != '' ? $portis_id_4 : '').'";
					','after');

	} // function cfrd__enqueue_scriptsCBF() 
