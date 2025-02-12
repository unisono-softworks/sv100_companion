<?php
	namespace sv100_companion;

	class sv_yoast_seo extends modules {
		public function init() {
			// Section Info
			$this->set_section_title( __( 'Yoast SEO', 'sv100_companion' ) )
				->set_section_desc( __( 'Tweaks for Yoast SEO', 'sv100_companion' ) )
				->set_section_type( 'settings' )
				->load_settings()
				->register_scripts()
				->get_root()->add_section($this);

			if($this->get_setting('faq_block_accordion')->get_data()){
				add_action('wp', array($this, 'faq_block_accordion'), 10);
			}
		}
		public function load_settings(): sv_yoast_seo{
			$this->get_setting('faq_block_accordion')
				->set_title( __( 'Display FAQ Block as Accordion', 'sv100_companion' ) )
				->load_type( 'checkbox' );

			return $this;
		}
		protected function register_scripts(): sv_yoast_seo {
			// Register Styles
			$this->get_script( 'faq_block_accordion' )
				->set_path( 'lib/frontend/css/faq_block_accordion.css' );

			// Register Scripts
			$this->get_script( 'faq_block_accordion_js' )
				->set_path( 'lib/frontend/js/faq_block_accordion.js' )
				->set_type( 'js' );

			return $this;
		}
		public function faq_block_accordion(): sv_yoast_seo{
			if(!$this->has_block_frontend('yoast/faq-block')){
				return $this;
			}

			$this->get_script( 'faq_block_accordion' )->set_is_enqueued();
			$this->get_script( 'faq_block_accordion_js' )->set_is_enqueued();

			return $this;
		}
	}