<?php
use Elliptic\EC;
use kornrunner\Keccak;

/**
 * Lock User
 */
add_action('wp','wpwlc_restrict_user');
function wpwlc_restrict_user(){
    global $post;
    if(is_admin())
    return;

    $limit_access = get_post_meta($post->ID,'wplmc_limit_access',true);
    if($limit_access != '1')
    return;
    
    if(is_user_logged_in()) {
        $user = wp_get_current_user();
        $selected_users = get_post_meta($post->ID,'wplmc_users_access',true);
        if(in_array($user->ID,$selected_users))
        return;
        else {
            wp_redirect(wp_login_url());
            exit;
        }
    }
    else {
        wp_redirect(wp_login_url());
        exit;
    }

}

 add_action('wp_ajax_connect_wallet','connect_wallet_ajax_cb');
 add_action('wp_ajax_nopriv_connect_wallet','connect_wallet_ajax_cb');
 function connect_wallet_ajax_cb(){
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    global $wpdb;
    require_once wpwlc_PATH."/lib/Keccak/Keccak.php";
    require_once wpwlc_PATH."/lib/Elliptic/EC.php";
    require_once wpwlc_PATH."/lib/Elliptic/Curves.php";
    //require_once wpwlc_PATH."/lib/JWT/jwt_helper.php";
    //$GLOBALS['JWT_secret'] = '4Eac8AS2cw84easd65araADX';
    $userObj = wp_get_current_user();

    
    $data = json_decode(file_get_contents("php://input"));
    $request = $data->request;

    // Create a standard of eth address by lowercasing them
    // Some wallets send address with upper and lower case characters
    if (!empty($data->address)) {
    $data->address = strtolower($data->address);
    }

    if ($request == "login") {
        $address = $data->address;
        $balance = $data->balance;

        // Prepared statement to protect against SQL injections
        // $stmt = $conn->prepare("SELECT nonce FROM $tablename WHERE address = ?");
        // $stmt->bindParam(1, $address);
        // $stmt->execute();
        // $nonce = $stmt->fetchColumn();
        $usermeta = $wpdb->get_results($wpdb->prepare("SELECT b.meta_value FROM `".$wpdb->prefix."usermeta` as a, `".$wpdb->prefix."usermeta` as b  WHERE a.meta_key LIKE 'wpwlc_address' AND a.meta_value LIKE '%s' AND b.meta_key LIKE 'wpwlc_nonce'  AND a.user_id LIKE b.user_id",$address));
        
        if (isset($usermeta[0])) {
            $nonce = $usermeta[0]->meta_value;
            // If user exists, return message to sign

            printf("Sign this message to validate that you are the owner of the account. Random string: %s", $nonce);
            update_user_meta($userObj->ID,'wpwlc_address',$address);
            update_user_meta($userObj->ID,'wpwlc_nonce',$nonce);
        }
        else {
            // If user doesn't exist, register new user with generated nonce, then return message to sign
            $nonce = uniqid();
            $user_id = wp_create_user( $address, wp_generate_password() );
            update_user_meta($user_id,'wpwlc_address',$address);
            update_user_meta($user_id,'wpwlc_nonce',$nonce);
            if($balance)
            update_user_meta($user_id,'wpwlc_balance',$balance);
            
            // Prepared statement to protect against SQL injections
            //$stmt = $conn->prepare("INSERT INTO $tablename (address, nonce) VALUES (?, ?)");
            //$stmt->bindParam(1, $address);
            //$stmt->bindParam(2, $nonce);

            if (!is_wp_error( $user_id ) ) {
                printf("Sign this message to validate that you are the owner of the account. Random string: %s", $nonce);
            } else {
                printf("Error",$user_id->get_error_message());
            }
        }

        exit;
    }

    if ($request == "auth") {
        $address = $data->address;
        $signature = $data->signature;

        // Prepared statement to protect against SQL injections
        $usermeta = $wpdb->get_results($wpdb->prepare("SELECT b.meta_value FROM `".$wpdb->prefix."usermeta` as a, `".$wpdb->prefix."usermeta` as b  WHERE a.meta_key LIKE 'wpwlc_address' AND a.meta_value LIKE '%s' AND b.meta_key LIKE 'wpwlc_nonce' AND a.user_id LIKE b.user_id",$address));
        if(isset($usermeta[0])) {
            
            $nonce = $usermeta[0]->meta_value;
            printf("Sign this message to validate that you are the owner of the account. Random string: %s", $nonce);

        }

        // Check if the message was signed with the same private key to which the public address belongs
        function pubKeyToAddress($pubkey) {
            return "0x" . substr(Keccak::hash(substr(hex2bin($pubkey->encode("hex")), 1), 256), 24);
        }

        function verifySignature($message, $signature, $address) {
            $msglen = strlen($message);
            $hash   = Keccak::hash("\x19Ethereum Signed Message:\n{$msglen}{$message}", 256);
            $sign   = ["r" => substr($signature, 2, 64),
                    "s" => substr($signature, 66, 64)];
            $recid  = ord(hex2bin(substr($signature, 130, 2))) - 27;
            if ($recid != ($recid & 1))
                return false;

            $ec = new EC('secp256k1');
            $pubkey = $ec->recoverPubKey($hash, $sign, $recid);

            return $address == pubKeyToAddress($pubkey);
        }

        // If verification passed, authenticate user
        if (verifySignature($message, $signature, $address)) {

         //   $stmt = $conn->prepare("SELECT publicName FROM $tablename WHERE address = ?");
           // $stmt->bindParam(1, $address);
           // $stmt->execute();
           // $publicName = $stmt->fetchColumn();
            $usermeta = $wpdb->get_results($wpdb->prepare("SELECT b.* FROM `".$wpdb->prefix."usermeta` as a, `".$wpdb->prefix."usermeta` as b  WHERE a.meta_key LIKE 'wpwlc_address' AND a.meta_value LIKE '%s' AND b.meta_key LIKE 'nickname' AND a.user_id LIKE b.user_id",$address));    
            
            $user_id = $usermeta[0]->user_id;
            $publicName = $usermeta[0]->meta_value;
            $publicName = htmlspecialchars($publicName, ENT_QUOTES, 'UTF-8');

            // Create a new random nonce for the next login
            $nonce = uniqid();
            update_user_meta($user_id,'wpwlc_nonce',$nonce);
            //$sql = "UPDATE $tablename SET nonce = '".$nonce."' WHERE address = '".$address."'";
            //$conn->query($sql);

            // Create JWT Token
            //$token = array();
            //$token['address'] = $address;
            //$JWT = JWT::encode($token, $GLOBALS['JWT_secret']);

            /**Login the user */
             clean_user_cache( $user_id );
             wp_clear_auth_cookie();
             wp_set_current_user( $user_id );
             wp_set_auth_cookie( $user_id, false );
             update_user_caches( get_user_by('ID',$user_id) );


            echo (json_encode(["Success", $publicName]));
        } else {
            esc_html_e("Fail",'wallet-login');
        }
        exit;
    }

    if ($request == "updatePublicName") {
    $publicName = $data->publicName;
    $address = $data->address;

    // Check if the user is logged in
    if(!is_user_logged_in()){
        //$JWT = JWT::decode($data->JWT, $GLOBALS['JWT_secret']); 
        esc_html_e( 'Authentication error','wallet-login'); 
        exit; 
    }
    

    // Prepared statement to protect against SQL injections
    $usermeta = $wpdb->get_results($wpdb->prepare("SELECT b.* FROM `".$wpdb->prefix."usermeta` as a, `".$wpdb->prefix."usermeta` as b  WHERE a.meta_key LIKE 'wpwlc_address' AND a.meta_value LIKE '%s' AND b.meta_key LIKE 'nickname' AND a.user_id LIKE b.user_id",$address));                
    $user_id = $usermeta[0]->user_id;
    //$stmt = $conn->prepare("UPDATE $tablename SET publicName = ? WHERE address = '".$address."'");
    //$stmt->bindParam(1, $publicName);
        update_user_meta($user_id,'nickname',true);
    if (isset($usermeta[0])) {
        printf("Public name for %s updated to %s ",$address,$publicName);
    }


    exit;
    }

     die();
 }


    add_action('login_form', 'also_add_connect_wallet_model_inlogin_registformCBF');
    add_action('register_form', 'also_add_connect_wallet_model_inlogin_registformCBF');
    function also_add_connect_wallet_model_inlogin_registformCBF(){

        echo do_shortcode('[connect_wallet]');
       
    } // function also_add_connect_wallet_model_inloginformCBF










if(!class_exists("WPBakeryShortCode"))
return;
class WPBakeryShortCodeConnectWallet extends WPBakeryShortCode {

  function __construct() {
    add_action( 'init', array( $this, 'create_shortcode' ), 999 );            
    add_shortcode( 'wpbakery_connect_wallet', array( $this, 'render_shortcode' ) );
  }        

  public function create_shortcode() {
    if ( !defined( 'WPB_VC_VERSION' ) ) {
      return;
    }  
   
    

    vc_map( array(
      'name'          => __('Connect Wallet', 'wallet-login'),
      'base'          => 'wpbakery_connect_wallet',
      'description'  	=> __( 'Connect Wallet','wallet-login'),
      //'category'      => __( 'msl_txtdmn Modules', 'msl_txtdmn'),                
      'params' => array(
        array(
          'type' => 'colorpicker',
          'heading' => esc_html__('Select Button Background Color','wallet-login'),
          'param_name' => 'button_background_color',
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Select Button Text Color','wallet-login'),
            'param_name' => 'button_text_color',
          ),
      ),
    ));             

    

  }

  public function render_shortcode( $atts, $content, $tag ) {
    $content            = wpb_js_remove_wpautop($content, true);
            
    if(is_admin())
      return;

        $Button_Background_Color = isset($atts['button_background_color']) ? $atts['button_background_color'] : 'green';
        $Button_Text_Color = isset($atts['button_text_color']) ? $atts['button_text_color'] : 'white';

    ob_start();
    ?>
    
    <div style="margin: 0 auto;max-width: 600px;margin-top:100px;">
        <div style="text-align:center;word-wrap:break-word;">
            <?php if(is_user_logged_in()) {
                $user = wp_get_current_user();
                $address = get_user_meta($user->ID,'wpwlc_address',true);
                
                ?>
                <div id="loggedIn" class="user-login-msg">
                <?php printf('Successful authentication for address: <br /><span id="ethAddress">%s</span>',$address);?>
                    <br><br>
                    <?php esc_html_e("You can set a public name for this account:",'wallet-login');?><br>
                    <input type="text" placeholder="Public name" id="updatePublicName" onfocusout="setPublicName()" style="width:190px;">
                </div>
            <?php } //if(is_user_logged_in()) {
                else
                printf('<button type="button" onclick="userLoginOut()" id="buttonText" class="button" style="background-color:%s;color:%s">'.__("Connect Wallet",'wallet-login').'</button><div><p>&nbsp;</p></div>',$Button_Background_Color,$Button_Text_Color);
            ?>
        </div>
    </div>
    
     <?php

     $ob_str=ob_get_contents();
     ob_end_clean();
     return $ob_str;


  } // functi

} // class

new WPBakeryShortCodeConnectWallet();
