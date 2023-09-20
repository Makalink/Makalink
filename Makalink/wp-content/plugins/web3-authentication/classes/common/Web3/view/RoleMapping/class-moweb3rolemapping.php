<?php
/**
 * Core
 *
 * Create MoWeb3 Method view Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\MoWeb3MethodViewHandler
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\view\RoleMappingView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\view\ButtonView\MoWeb3View;

if ( ! class_exists( 'MoWeb3\view\RoleMappingView\MoWeb3RoleMapping' ) ) {


	/**
	 * Class to Create MoWeb3 Method View Handler.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\view\RoleMappingView
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3RoleMapping {
		/**
		 * Instance of utils class
		 *
		 * @var $util
		 */
		public $util;
		/**
		 * Instance of MoWeb3View class
		 *
		 * @var $button_view
		 */
		public $button_view;
		/**
		 * Constructor
		 */
		public function __construct() {

			$this->util        = new \MoWeb3\MoWeb3Utils();
			$this->button_view = new \MoWeb3\view\ButtonView\MoWeb3View();
			$this->button_view->mo_web3_wp_enqueue();

		}

		/**
		 * Function that renders Attribute Mapping Section.
		 */
		public function view() {
			global $mo_web3_util;
			$check_versi  = 0;
			$disabled     = $check_versi ? 'disabled="true"' : '';
			$required     = $check_versi ? 'required="false"' : '';
			$role_mapping = $mo_web3_util->mo_web3_get_option( 'mo_web3_role_mapping' );
			if ( ! $role_mapping ) {
				$role_mapping = array();
			}
			$role_mapping['enable_role_mapping']              = isset( $role_mapping['enable_role_mapping'] ) ? $role_mapping['enable_role_mapping'] : false;
			$role_mapping['keep_existing_user_roles']         = isset( $role_mapping['keep_existing_user_roles'] ) ? $role_mapping['keep_existing_user_roles'] : false;
			$role_mapping['dont_disturb_existing_user_roles'] = isset( $role_mapping['dont_disturb_existing_user_roles'] ) ? $role_mapping['dont_disturb_existing_user_roles'] : false;
			$role_mapping['restrict_login_for_mapped_roles']  = isset( $role_mapping['restrict_login_for_mapped_roles'] ) ? $role_mapping['restrict_login_for_mapped_roles'] : false;
			$role_mapping['_mapping_value_default']           = isset( $role_mapping['_mapping_value_default'] ) ? $role_mapping['_mapping_value_default'] : false;
			$role_mapping['role_mapping_count']               = isset( $role_mapping['role_mapping_count'] ) ? $role_mapping['role_mapping_count'] : 0;
			$role_mapping['groupname_attribute']              = isset( $role_mapping['groupname_attribute'] ) ? $role_mapping['groupname_attribute'] : '';
			?>
			<div class="mo_table_layout prem-info" id="rolemapping">
			<div class="mo_web3_small_layout" style="margin-top:0px;">

				<div class="mb-4">
				<?php
					$this->util->render_premium_info_ui( 'Role mapping is configurable in the Enterprise and All-Inclusive plans.', 'https://developers.miniorange.com/docs/wordpress-web3/features/role-mapping');
				?>
					<div class="row">
						<div class="col-11">
							<h1>Role Mapping (Optional)</h1>
						</div>
					</div>            
				</div>

			<div class="row">
				<div class="col-11">			
			<form id="enable_role_mapping_form" method="post" action="">
				<input type="hidden" name="option" value="mo_web3_enable_role_mapping" />
				<?php wp_nonce_field( 'mo_web3_enable_role_mapping', 'mo_web3_enable_role_mapping_nonce' ); ?>
					<div class="row mb-4">
							<div class="col-12 col-sm-4">
							<h6>Enable Role Mapping:</h6>
							</div>

							<div class="col-12 col-sm-8">
							<input type="checkbox" class="cursor-disabled" disabled 
							<?php
								echo esc_attr( $disabled );
								echo esc_attr( ! $check_versi ) ? 'id="enable_role_mapping" name="enable_role_mapping" value="true" ' . checked( esc_attr( boolval( $role_mapping['enable_role_mapping'] ) === true ) ) . '" ' : ' ';
							?>
							> 
							<label class="display-inline"  for="checkbox">Once enabled, user will mapped to roles based NFTs he own</label>
							</div>
					</div>
					<hr>
			</form>
			<?php
			if ( ! boolval( $role_mapping['enable_role_mapping'] ) ) {
				echo '<p style=color:red><strong>Enable Role Mapping</strong> to configure role mapping.</p>';
			}
			?>
			<strong>NOTE: </strong>Role will be assigned only to non-admin users (user that do NOT have Administrator privileges). You will have to manually change the role of Administrator users.<br>
			<hr>	
			<form id="role_mapping_form" name="f" method="post" action="">
				<input   type="hidden" name="option" value="mo_web3_save_role_mapping" />
				<?php wp_nonce_field( 'mo_web3_save_role_mapping', 'mo_web3_save_role_mapping_nonce' ); ?>
				<div class="row mb-4">
					<div class="col-12 col-sm-4">
						<h6>Keep existing user roles:</h6>
					</div>
					<div class="col-12 col-sm-8">
						<input  type="checkbox" name="keep_existing_user_roles" value="true" class="cursor-disabled"  disabled
				<?php
					echo esc_attr( checked( boolval( $role_mapping['keep_existing_user_roles'] ) === true ) );
				?>
				/>
				<label  class = 'display-inline' for = 'checkbox' > Role mapping will not apply to existing WordPress users .
				</label>
					</div>
				</div>
				<div class= 'row mb-4' >
					<div class = 'col-12 col-sm-4' >
						<h6> do not disturb existing user roles: </h6>
					</div>
					<div class= 'col-12 col-sm-8' >
						<input type = 'checkbox' name = 'dont_disturb_existing_user_roles' value = 'true' class = 'cursor-disabled'  disabled
					<?php
						echo esc_attr( checked( boolval( $role_mapping['dont_disturb_existing_user_roles'] ) === true ) );
					?>
				/>
				<label  class="display-inline" for="checkbox"> Existing roles will not be disturb while doing role mapping
				</label>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-12 col-sm-4">
						<h6>Don't allow login:</h6>
					</div>
					<div class="col-12 col-sm-8">
						<input type="checkbox" class="cursor-disabled" disabled
						<?php
							echo esc_attr( $disabled );
							echo esc_attr( ! $check_versi ) ? 'name="restrict_login_for_mapped_roles" value="true" ' . esc_attr( checked( boolval( $role_mapping['restrict_login_for_mapped_roles'] ) === true ) ) . '" ' : ' ';
						?>
						/>
						<label  class="display-inline" for="checkbox"> We won't allow users to login if we don't find users role/group mapped below.
						</label>
					</div>
				</div>

				<div id="inputFormRow">
					<div class="row">
						<label  class="col-sm-4">
							<h6>Default Role: </h6>
						</label>
						<div class="col-sm-8 form-group mb-3">
							<select  disabled class="form-select" name="_mapping_value_default" style="width:60%;height:35px;" id="default_group_mapping" <?php echo $role_mapping['restrict_login_for_mapped_roles'] ? 'disabled="true"' : ' '; ?>  >
							<?php
							$default_role = ( $role_mapping['_mapping_value_default'] ) ? $role_mapping['_mapping_value_default'] : 'subscriber';
							wp_dropdown_roles( $default_role );
							?>
							</select>
							<select class="form-select" style="display:none" id="wp_roles_list"><?php wp_dropdown_roles( $default_role ); ?>
							</select>                       
						<em> Default role will be assigned to all users for which mapping is not specified.</em>
						</div>
					</div>

					<table class="mo_web3_mapping_table" id="mo_web3_role_mapping_table" style="width:90%;margin-top: 10%;">
						<tr>
							<td style="width:50%"><h6>Contract Address</h6><?php echo esc_html( $check_versi ) ? '&emsp;<small class="mo_premium_feature">[PREMIUM]</small>' : ''; ?></td>
							<td style="width:50%"><h6 style="text-align: center">WordPress Role</h6></td>
						</tr>

						<?php
						$mapping_count = is_numeric( $role_mapping['role_mapping_count'] ) ? intval( $role_mapping['role_mapping_count'] ) : 1;
						for ( $i = 1; $i <= $mapping_count; $i++ ) {
							?>
						<tr class="rows">
							<td><input  class="form-control" type="text" name="mapping_key_[<?php echo wp_kses( $i, \mo_web3_get_valid_html() ); ?>][value]" id="<?php echo isset( ( $role_mapping[ '_mapping_key_' . $i ] ) ) ? esc_attr( $role_mapping[ '_mapping_key_' . $i ] ) : ''; ?>"
								value="<?php echo isset( ( $role_mapping[ '_mapping_key_' . $i ] ) ) ? esc_attr( $role_mapping[ '_mapping_key_' . $i ] ) : ''; ?>"  placeholder="contract address"  />
							</td>
							<td>
								<select disabled name="mapping_key_[<?php echo wp_kses( $i, \mo_web3_get_valid_html() ); ?>][role]" id="role" style="width:60%;height:35px;margin: auto;" class="form-select">

								<?php wp_dropdown_roles( isset( ( $role_mapping[ '_mapping_value_' . $i ] ) ) ? esc_attr( $role_mapping[ '_mapping_value_' . $i ] ) : '' ); ?>
								</select>
							</td>
							<td>
								<img onclick="mo_remove_custom_attribute_ld(this)" width="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'minus-remove-icon.svg'; ?>" id="removeRow" />							
							</td>
						</tr>
						<?php } ?>
						<script>
						function mo_remove_custom_attribute_ld(o){
							var getRows = document.getElementsByClassName("rows");
							var thisRow = o.parentNode.parentNode;  
							if(thisRow.parentNode.childElementCount > 2){
									thisRow.parentNode.removeChild(thisRow);
								}   
						}
						</script>
							<?php

							if ( 0 === $mapping_count ) {
								?>
						<tr class="rows">
							<td><input  class="cursor-disabled" disabled class="form-control" type="text"
								<?php
									echo esc_attr( $disabled );
									echo esc_attr( ! $check_versi ) ? ' name="mapping_key_[1][value]" value=""' : ' ';
								?>
								placeholder="contract address" />
							</td>
							<td>
								<select  class="cursor-disabled" disabled style="width:100%"
								<?php
									echo esc_attr( $disabled );
									echo esc_attr( ! $check_versi ) ? ' name="mapping_key_[1][role]" id="role"' : ' ';
								?>
								>
								<?php wp_dropdown_roles(); ?>
								</select>
							</td>
							<td>
								<img class="cursor-disabled"  width="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'minus-remove-icon.svg'; ?>" id="removeRow"  />
							</td>
						</tr>
								<?php
							}
							?>
					</table>
						<table class="mo_web3_mapping_table" style="width:90%;">
							<tr><td><a  class="cursor-disabled" style="pointer-events:none;color: blue;<?php echo esc_attr( $check_versi ) ? 'display:none;' : ''; ?>" id="add_mapping">Add More Mapping</a><br><br></td><td>&nbsp;</td></tr>
							<tr>
								<td><input    type="button" class="button button-primary button-large" value="Save Mapping" class="cursor-disabled"></td>
								<td>&nbsp;</td>
							</tr>
						</table>
						</div>
					</form>
					</div>
					</div>
				</div>
			</div>
			<script>
				enable_role_mapping.onclick = function() {

					var checkbox=document.getElementById("enable_role_mapping");

					if(checkbox.checked){
						checkbox.value=true;
					}else{
						checkbox.value=false;
					}

					jQuery('#enable_role_mapping_form').submit();

				}

				jQuery('#add_mapping').click(function() {
					var last_index_name = jQuery('#mo_web3_role_mapping_table tr:last .form-control').attr('name');						
					if(last_index_name)
					{
						var splittedArray = last_index_name.split("_");
						var intermediate_array_1=splittedArray[splittedArray.length-1];
						var intermediate_array_2=intermediate_array_1.split("[");
						var intermediate_array_3=intermediate_array_2[1].split("]");
						var last_index = parseInt(intermediate_array_3[0])+1;
					}
					var dropdown = jQuery("#wp_roles_list").html();				
					if(last_index){}
					else{last_index=1};
					var new_row = '<tr class="rows"><td><input class="form-control" type="text" placeholder="contract address" name="mapping_key_['+last_index+'][value]" value="" /></td><td><select name="mapping_key_['+last_index+'][role]" class="form-select" style="width:60%;height:35px;margin: auto;" id="role">'+dropdown+'</select></td><td><img  style="cursor:pointer;" width="30" src="<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'minus-remove-icon.svg'; ?>" id="removeRow" onclick="mo_remove_custom_attribute_ld(this)"  /></td></tr>';
					jQuery('#mo_web3_role_mapping_table tr:last').after(new_row);				
				});

			</script>
			<?php
		}

	}
}
?>
