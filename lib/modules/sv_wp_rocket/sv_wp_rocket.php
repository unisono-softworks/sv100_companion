<?php
	namespace sv100_companion;

	class sv_wp_rocket extends modules {
		public function init() {
			// Section Info
			$this->set_section_title( __( 'WP Rocket', 'sv100_companion' ) )
				 ->set_section_desc( __( 'Tweaks for WP Rocket', 'sv100_companion' ) )
				 ->set_section_type( 'settings' );
			
			$this->get_root()->add_section($this);
			
			$this->load_settings();
			
			if($this->get_setting('lazy_load_threshold')->get_data()){
				add_filter( 'rocket_lazyload_threshold', function($threshold){
					return $this->get_setting('lazy_load_threshold')->get_data();
				} );
			}
			if($this->get_setting('lazy_load_videos')->get_data()) {
				add_filter('rocket_buffer', array($this, 'lazy_load_videos'), 999999);
				add_filter( 'rocket_lazyload_script_args', array($this, 'lazy_load_videos_args') );
			}
		}
		public function load_settings(): sv_wp_rocket{
			$this->get_setting('lazy_load_threshold')
				 ->set_title( __( 'Adjust Threshold for Lazy Loading', 'sv100_companion' ) )
				 ->set_description( __( sprintf('see %sWP-Rocket-Manual%s.', '<a href="https://docs.wp-rocket.me/article/1032-adjust-lazyload-threshold" target="_blank">', '</a>'), 'sv100_companion' ) )
				 ->load_type( 'number' );

			$this->get_setting('lazy_load_videos')
				->set_title( __( 'Activate lazyloading for HTML5 video elements', 'sv100_companion' ) )
				->load_type( 'checkbox' );

			return $this;
		}
		public function lazy_load_videos($buffer){
			preg_match_all('/<video (.*?)\>/', $buffer, $videos);
			if(!is_null($videos)) {
				foreach($videos[1] as $index => $value) {
					if(!preg_match('/data-src=/', $value)){ // not prepared for lazyload yet
						$new_video = str_replace(array(
							'class="',
							'src=',
							'poster='
						), array(
							'class="rocket-lazyload ',
							'data-lazy-src=',
							'data-poster='
						), $videos[0][$index]);
						$buffer = str_replace($videos[0][$index], $new_video, $buffer);
					}
				}
			}

			return $buffer;
		}
		public function lazy_load_videos_args($inline_args){
			$inline_args['elements']['video']            = 'video[data-lazy-src]';

			return $inline_args;
		}
	}