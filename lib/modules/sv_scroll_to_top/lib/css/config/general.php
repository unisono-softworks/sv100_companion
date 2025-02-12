<?php
	$properties					                                 = array();

	$active = array_map(function ($val) {
		if($val === '1'){
			return 'block';
		}

		return 'none';
	}, $module->get_setting('activate')->get_data());

	$properties['display']	= $active;

	echo $_s->build_css(
		'#sv100_companion_sv_scroll_to_top.show',
		array_merge(
			$properties,
			$module->get_setting('bg_color')->get_css_data('background-color'),
			$module->get_setting('box_size')->get_css_data('width', '', 'px'),
			$module->get_setting('box_size')->get_css_data('height', '', 'px'),
			$module->get_setting('position_top')->get_css_data('top'),
			$module->get_setting('position_right')->get_css_data('right'),
			$module->get_setting('position_bottom')->get_css_data('bottom'),
			$module->get_setting('position_left')->get_css_data('left'),
		)
	);

	echo $_s->build_css(
		'#sv100_companion_sv_scroll_to_top:hover, #sv100_companion_sv_scroll_to_top:focus',
		array_merge(
			$module->get_setting('bg_color_hover')->get_css_data('background-color')
		)
	);

	$properties						= array();
	$icon = array_map(function ($val) {
		if(strlen($val) > 0){
			return 'url(\'data:image/svg+xml;utf8;base64,'.base64_encode($val).'\')';
		}
		return '';
	}, $module->get_setting('icon')->get_data());

	$properties['-webkit-mask-image']	= $icon;

	echo $_s->build_css(
		'#sv100_companion_sv_scroll_to_top > i',
		array_merge(
			$properties,
			$module->get_setting('icon_color')->get_css_data('background-color'),
			$module->get_setting('icon_size')->get_css_data('-webkit-mask-size', '', 'px')
		)
	);

	echo $_s->build_css(
		'#sv100_companion_sv_scroll_to_top:hover > i, #sv100_companion_sv_scroll_to_top:focus > i ',
		array_merge(
			$module->get_setting('icon_color_hover')->get_css_data('background-color')
		)
	);