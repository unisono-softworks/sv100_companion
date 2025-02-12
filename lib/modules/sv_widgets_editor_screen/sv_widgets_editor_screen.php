<?php
	namespace sv100_companion;

	class sv_widgets_editor_screen extends modules {
		public function init() {
			$this->load_settings()
			     ->register_scripts()
			     ->set_section_title( __( 'Widgets Editor Screen', 'sv100_companion' ) )
			     ->set_section_desc( __( 'Widget Area Enhancements', 'sv100_companion' ) )
			     ->set_section_type( 'settings' )
			     ->get_root()
			     ->add_section( $this );
		}
		public function register_scripts(){
			if(is_admin() && $this->get_setting( 'edit_screen_max_width' )->get_data()) {
				$this->get_script('edit_screen_max_width')
					->set_is_backend()
					->set_path('lib/css/common/edit_screen_max_width.css')
					->set_is_enqueued();
			}
			
			return $this;
		}
		public function load_settings(){
			$this->get_setting( 'edit_screen_max_width' )
			     ->set_title( __( 'Edit Screen Max Width', 'sv100_companion' ) )
			     ->set_description( __( 'Enable easier editing of complex layouts with a wider edit screen.', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );
			
			return $this;
		}
	}
