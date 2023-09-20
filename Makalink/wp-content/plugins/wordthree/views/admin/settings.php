<style>
	.tooltip {
		position: relative;
		display: inline-block;
	}

	.tooltip .tooltiptext {
		visibility: hidden;
		width: 45px;
		background-color: #555;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px;
		position: absolute;
		z-index: 1;
		bottom: 85%;
		/*left: 60%;*/
		margin-left: -30px;
		opacity: 0;
		transition: opacity 0.3s;
	}

	.tooltip .tooltiptext::after {
		content: "";
		position: absolute;
		top: 100%;
		left: 40%;
		margin-left: -5px;
		border-width: 5px;
		border-style: dotted;
		border-color: #555 transparent transparent transparent;
	}

	.tooltip:hover .tooltiptext {
		visibility: visible;
		opacity: 1;
	}
</style>
<div class="wt-metamask-wrap">
	<h2><?php esc_html_e('MetaMask Settings', 'wordthree'); ?></h2>
	<div class="wrap inner-wrap">
		<?php settings_errors(); ?>
		<h2 style="display: none"></h2>
		<form method="post" action="options.php">
			<?php
			settings_fields('wordthree_option_group');
			do_settings_sections('wordthree-settings');
			submit_button();
			?>
		</form>

		<div class="note">
			<strong><?php esc_html_e('Note:', 'wordthree'); ?> </strong>
			<em><?php esc_html_e('Use', 'wordthree'); ?></em><br/>

			<input type="text" class="login-shortcode" value="[wordthree_metamask_login]" readonly
				   style="width: 200px;">
			<em><?php esc_html_e('shortcode to display login button.', 'wordthree'); ?></em>
			<div class="tooltip">
				<a class="copy-shortcode-btn" data-target-copy=".login-shortcode">
                    <img width="20px" src="<?=WORDTHREE_METAMASK_PLUGIN_URL.'assets/icon/copy.png'?>" alt="">
					<span class="tooltiptext" data-text-original="<?php esc_attr_e('Copy', 'wordthree'); ?>"
						  data-text-copied="<?php esc_attr_e('Copied', 'wordthree'); ?>">
						<?php esc_html_e('Copy', 'wordthree'); ?>
					</span>
				</a>
			</div>
			<br/>

			<input type="text" value="[wordthree_metamask_register]" class="register-shortcode" readonly
				   style="width: 215px;">
			<em><?php esc_html_e('shortcode to display register button.', 'wordthree'); ?></em>
			<div class="tooltip">
				<a class="copy-shortcode-btn" data-target-copy=".register-shortcode">
                    <img width="20px" src="<?=WORDTHREE_METAMASK_PLUGIN_URL.'assets/icon/copy.png'?>" alt="">
					<span class="tooltiptext" data-text-original="<?php esc_attr_e('Copy', 'wordthree'); ?>"
						  data-text-copied="<?php esc_attr_e('Copied', 'wordthree'); ?>">
						<?php esc_html_e('Copy', 'wordthree'); ?>
					</span>
				</a>
			</div>
			<br/>

			<input type="text" value="[wordthree_metamask_link]" class="link-shortcode" readonly style="width: 200px;">
			<em><?php esc_html_e('shortcode to display link with metamask button.', 'wordthree'); ?></em>
			<div class="tooltip">
				<a class="copy-shortcode-btn" data-target-copy=".link-shortcode">
                    <img width="20px" src="<?=WORDTHREE_METAMASK_PLUGIN_URL.'assets/icon/copy.png'?>" alt="">
					<span class="tooltiptext" data-text-original="<?php esc_attr_e('Copy', 'wordthree'); ?>"
						  data-text-copied="<?php esc_attr_e('Copied', 'wordthree'); ?>">
						<?php esc_html_e('Copy', 'wordthree'); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>
