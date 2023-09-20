<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly.


    class Connect_Wallet_Widget extends \Elementor\Widget_Base { 
  

        /**
       * Get widget name.
       *
       * Retrieve Connect_Wallet_Widget widget name.
       *
       * @since 1.0.0
       * @access public
       * @return string Widget name.
       */
      public function get_name() {
          return 'Connect_Wallet_Widget';
      }
  
  
      /**
       * Get widget title.
       *
       * Retrieve Connect_Wallet_Widget widget title.
       *
       * @since 1.0.0
       * @access public
       * @return string Widget title.
       */
      public function get_title() {
          return esc_html__( 'Connect Wallet Widget', 'wallet-login' );
      }
  
      /**
       * Get widget icon.
       *
       * Retrieve Connect_Wallet_Widget widget icon.
       *
       * @since 1.0.0
       * @access public
       * @return string Widget icon.
       */
      public function get_icon() {
          return 'eicon-header';
      }
  
  
      /**
       * Get custom help URL.
       *
       * Retrieve a URL where the user can get more information about the widget.
       *
       * @since 1.0.0
       * @access public
       * @return string Widget help URL.
       */
      public function get_custom_help_url() {
          return 'https://essentialwebapps.com/category/elementor-tutorial/';
      }
  
      /**
       * Get widget categories.
       *
       * Retrieve the list of categories the Connect_Wallet_Widget widget belongs to.
       *
       * @since 1.0.0
       * @access public
       * @return array Widget categories.
       */
      public function get_categories() {
          return [ 'general' ];
      }
  
      /**
       * Get widget keywords.
       *
       * Retrieve the list of keywords the Connect_Wallet_Widget widget belongs to.
       *
       * @since 1.0.0
       * @access public
       * @return array Widget keywords.
       */
      public function get_keywords() {
          return ['connect', 'wallet'];
      }
  
  
  
      /**
       * Register Card widget controls.
       *
       * Add input fields to allow the user to customize the widget settings.
       *
       * @since 1.0.0
       * @access protected
       */
      protected function register_controls() { 
          // our control function code goes here.
  
          $this->start_controls_section(
              'content_section',
              [
                  'label' => esc_html__( 'Content', 'wallet-login' ),
                  'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
              ]
          );
  
          $this->add_control(
              'Button_Background_Color',
              [
                  'label' => esc_html__( 'Button Background Color', 'wallet-login' ),
                  'type' => \Elementor\Controls_Manager::COLOR,
                  'label_block' => true,
              ]
          );
  
  
          $this->add_control(
            'Button_Text_Color',
            [
                'label' => esc_html__( 'Button Text Color', 'wallet-login' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'label_block' => true,
            ]
        );
  
          $this->end_controls_section();
  
      }
  
      /**
       * Render Card widget output on the frontend.
       *
       * Written in PHP and used to generate the final HTML.
       *
       * @since 1.0.0
       * @access protected
       */
      protected function render() { 
  
          if(is_admin())
          return;
    
           $settings = $this->get_settings_for_display();
  
           $Button_Background_Color = isset($settings['Button_Background_Color']) ? $settings['Button_Background_Color'] : 'green';
           $Button_Text_Color = isset($settings['Button_Text_Color']) ? $settings['Button_Text_Color'] : 'green';
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
  
      }
  
  }
?>