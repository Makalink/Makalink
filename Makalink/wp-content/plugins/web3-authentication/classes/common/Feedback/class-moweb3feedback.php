<?php
/**
 * App
 *
 * MoWeb3 Login Feedback Form.
 *
 * @category   Free
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class to Render Feedback Form.
 *
 * @category Core
 * @package  MoWeb3
 * @author   miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link     https://miniorange.com
 */

if ( ! class_exists( ' MoWeb3\MoWeb3Feedback ' ) ) {

	/**
	 * Class to Render Feedback Form.
	 *
	 * @category Core
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Feedback {



		/**
		 * Function to show form to user.
		 */
		public function show_form() {
			global $mo_web3_util;

			$path = isset( $_SERVER['PHP_SELF'] ) ? sanitize_text_field( wp_unslash( $_SERVER['PHP_SELF'] ) ) : '';
			if ( 'plugins.php' !== basename( $path ) ) {
				return;
			}
			$this->enqueue_styles();
			if ( $mo_web3_util->get_versi_str() === 'FREE' ) {
				$this->render_feedback_form();
			}
		}

		/**
		 * Function to enqueue required css/js.
		 */
		private function enqueue_styles() {
			global $mo_web3_util;
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
			if ( true === $mo_web3_util->is_developer_mode ) {
				wp_enqueue_style( 'mo_web3_feedback_style', MOWEB3_URL . 'classes/common/Feedback/resources/dev/feedback.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			} else {
				wp_enqueue_style( 'mo_web3_feedback_style', MOWEB3_URL . 'classes/common/Feedback/resources/prod/feedback.min.css', array(), $ver = \MoWeb3Constants::STYLES_CSS_VERSION, $in_footer = false );
			}
		}

		/**
		 * Function to render feedback form.
		 */
		private function render_feedback_form() {
			?>
			<div id="mo_web3_feedback_modal" class="mo_web3_modal">
				<div class="mo_web3_modal-content">
					<span class="mo_web3_close">&times;</span>
					<h3>Tell us what happened? </h3>
					<form name="f" method="post" action="" id="mo_web3_feedback">
						<input type="hidden" name="option" value="mo_web3_feedback"/>
						<?php wp_nonce_field( 'mo_web3_feedback', 'mo_web3_feedback_nonce' ); ?>
						<div>
							<p style="margin-left:2%">
							<?php $this->render_radios(); ?>
							<br>
							<textarea id="mo_web3_query_feedback" name="mo_web3_query_feedback" rows="4" style="margin-left:2%;width: 330px"
									placeholder="Write your query here"></textarea>
							<br><br>
							<div class="mo_web3_modal-footer">
								<input type="submit" name="miniorange_mo_feedback_submit"
									class="button button-primary button-large" style="float: left;" value="Submit"/>
								<input id="mo_web3_skip" type="submit" name="miniorange_mo_feedback_skip"
									class="button button-primary button-large" style="float: right;" value="Skip"/>
							</div>
						</div>
					</form>
					<form name="f" method="post" action="" id="mo_web3_feedback_form_close">
						<input type="hidden" name="option" value="mo_web3_skip_feedback"/>
						<?php wp_nonce_field( 'mo_web3_skip_feedback', 'mo_web3_skip_feedback_nonce' ); ?>
					</form>
				</div>
			</div>
			<?php
			$this->emit_script();
		}

		/**
		 * Function to emit JS.
		 */
		private function emit_script() {
			?>
			<script>
				jQuery('a[aria-label="Deactivate Web3 - Crypto wallet Login & NFT token gating"]').click(function () {
					var mo_web3_modal = document.getElementById('mo_web3_feedback_modal');
					var mo_skip = document.getElementById('mo_web3_skip');
					var span = document.getElementsByClassName("mo_web3_close")[0];
					mo_web3_modal.style.display = "block";
					jQuery('input:radio[name="mo_web3_deactivate_reason_radio"]').click(function () {
						var reason = jQuery(this).val();
						var query_feedback = jQuery('#mo_web3_query_feedback');
						query_feedback.removeAttr('required')
						if (reason === "Does not have the features I'm looking for") {
							query_feedback.attr("placeholder", "Let us know what feature are you looking for");
						} else if (reason === "Other Reasons:") {
							query_feedback.attr("placeholder", "Can you let us know the reason for deactivation");
							query_feedback.prop('required', true);
						} else if (reason === "Bugs in the plugin") {
							query_feedback.attr("placeholder", "Can you please let us know about the bug in detail?");
						} else if (reason === "Confusing Interface") {
							query_feedback.attr("placeholder", "Finding it confusing? let us know so that we can improve the interface");
						} else if (reason === "Endpoints not available") {
							query_feedback.attr("placeholder", "We will send you the Endpoints shortly, if you can tell us the name of your OAuth Server/App?");
						} else if (reason === "Unable to register") {
							query_feedback.attr("placeholder", "Error while receiving OTP? Can you please let us know the exact error?");
						}
					});
					span.onclick = function () {
						mo_web3_modal.style.display = "none";
					}
					mo_web3_skip.onclick = function() {
						mo_web3_modal.style.display = "none";
						jQuery('#mo_web3_feedback_form_close').submit();
					}
					window.onclick = function (event) {
						if (event.target == mo_web3_modal) {
							mo_web3_modal.style.display = "none";
						}
					}
					return false;
				});
			</script>
			<?php
		}

		/**
		 * Function renders radio boxes.
		 */
		private function render_radios() {
			$deactivate_reasons = array(
				'Does not have the features I am looking for',
				'Confusing Interface',
				'Bugs in the plugin',
				'Unable to register to miniOrange',
				'Other Reasons',
			);
			foreach ( $deactivate_reasons as $deactivate_reason ) {
				?>
				<div type="radio" style="padding:1px;margin-left:2%;">
					<label style="font-weight:normal;font-size:14.6px" for="<?php echo esc_attr( $deactivate_reason ); ?>">
						<input type="radio" style="display: inline-block;" name="mo_web3_deactivate_reason_radio" value="<?php echo esc_attr( $deactivate_reason ); ?>"
							required>
						<?php echo wp_kses( $deactivate_reason, \mo_web3_get_valid_html() ); ?>
					</label>
				</div>
				<?php
			}
		}
	}
}
?>
