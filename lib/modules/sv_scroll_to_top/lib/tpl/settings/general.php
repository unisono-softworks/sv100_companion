<?php if ( current_user_can( 'activate_plugins' ) ) { ?>
	<div class="sv_setting_subpage">
		<h2><?php _e('General', 'sv100_companion'); ?></h2>
		<h3 class="divider"><?php _e( 'Icon & Sizes', 'sv100_companion' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'activate' )->form();
				echo $module->get_setting( 'icon' )->form();
				echo $module->get_setting( 'box_size' )->form();
				echo $module->get_setting( 'icon_size' )->form();
			?>
		</div>
		<h3 class="divider"><?php _e( 'Position', 'sv100_companion' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'position_top' )->form();
				echo $module->get_setting( 'position_right' )->form();
				echo $module->get_setting( 'position_bottom' )->form();
				echo $module->get_setting( 'position_left' )->form();
			?>
		</div>
		<h3 class="divider"><?php _e( 'Colors', 'sv100_companion' ); ?></h3>
		<div class="sv_setting_flex">
			<?php
				echo $module->get_setting( 'icon_color' )->form();
				echo $module->get_setting( 'icon_color_hover' )->form();
				echo $module->get_setting( 'bg_color' )->form();
				echo $module->get_setting( 'bg_color_hover' )->form();
			?>
		</div>
	</div>
<?php } ?>