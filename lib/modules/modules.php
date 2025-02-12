<?php
	namespace sv100_companion;
	
	class modules extends init {
		public function init() {
			$this->load_module('sv_cleanup');
			$this->load_module('sv_human_time');
			$this->load_module('sv_settings');
			$this->load_module('sv_wp_rocket');
			$this->load_module('sv_svg_support');
			$this->load_module('sv_lightbox');
			$this->load_module('sv_smooth_scrolling');
			$this->load_module('sv_scroll_to_top');
			$this->load_module('sv_maintenance');
			$this->load_module('sv_planet_charts');
			$this->load_module('sv_gutenberg');
			$this->load_module('sv_accordion_block');
			$this->load_module('sv_woocommerce');
			$this->load_module('sv_yoast_seo');
			$this->load_module('sv_widgets_editor_screen');
			$this->load_module('sv_featured_image');
			$this->load_module('sv_rankmath');
			$this->load_module('security');
		}
	}