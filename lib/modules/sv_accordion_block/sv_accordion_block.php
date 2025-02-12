<?php
	namespace sv100_companion;

	class sv_accordion_block extends modules {
		public function init() {
			// Section Info
			$this->set_section_title( __( 'Accordion Block', 'sv100_companion' ) )
				->set_section_desc( __( 'Tweaks for Accordion Block', 'sv100_companion' ) )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section($this);

			if($this->get_setting('assets_on_demand')->get_data()){
				add_action( 'wp_enqueue_scripts', array($this, 'wp_print_scripts'), 100 );
				add_action( 'wp', array($this, 'wp_print_scripts'), 100 );
			}
		}
		public function wp_print_scripts() {
			if(is_admin()){
				return $this;
			}

			if($this->has_block_frontend('pb/accordion-item')){
				return $this;
			}

			if(!\WP_Block_Type_Registry::get_instance()->is_registered( 'pb/accordion-item' )){
				return $this;
			}

			unregister_block_type( 'pb/accordion-item');

			wp_dequeue_style('pb-accordion-blocks-style');
			wp_dequeue_script('pb-accordion-blocks-script');
			wp_dequeue_script('pb-accordion-blocks-frontend-script');

			return $this;
		}
		public function load_settings(): sv_accordion_block{
			$this->get_setting('assets_on_demand')
				->set_title( __( 'Load Assets on Demand', 'sv100_companion' ) )
				->set_description( __('Load Assets (CSS/JS) only, when Gutenberg Block is loaded on a page', 'sv100_companion' ) )
				->load_type( 'checkbox' );

			return $this;
		}
	}