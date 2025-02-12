<?php
	namespace sv100_companion;

	class sv_planet_charts extends modules {
		public function init() {
			// Section Info
			$this->set_section_title( __( 'Planet Charts', 'sv100_companion' ) )
				->set_section_desc( __( 'Tweaks for Planet Charts', 'sv100_companion' ) )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section($this);

			if($this->get_setting('assets_on_demand')->get_data()){
				add_action( 'wp_print_scripts', array($this, 'wp_print_scripts'), 100 );
			}
		}
		public function wp_print_scripts() {
			if(is_admin()){
				return $this;
			}

			if($this->has_block_frontend('planet-charts/chart')){
				return $this;
			}

			wp_dequeue_script('chart-js');
			wp_dequeue_script('chartjs-plugin-datalabels');
			wp_dequeue_script('planet-charts');

			return $this;
		}
		public function load_settings(): sv_planet_charts{
			$this->get_setting('assets_on_demand')
				->set_title( __( 'Load Assets on Demand', 'sv100_companion' ) )
				->set_description( __('Load Assets (CSS/JS) only, when Gutenberg Block is loaded on a page', 'sv100_companion' ) )
				->load_type( 'checkbox' );

			return $this;
		}
	}