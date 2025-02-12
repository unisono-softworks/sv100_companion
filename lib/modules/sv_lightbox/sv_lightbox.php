<?php
namespace sv100_companion;

class sv_lightbox extends modules {
	public function init() {
		// Section Info
		$this->set_section_title( __( 'Lightbox', 'sv100_companion' ) )
		->set_section_desc( __( 'Manage Lightbox', 'sv100_companion' ) )
		->set_section_type( 'settings' )
		->get_root()->add_section( $this );

		$this->load_settings()->register_scripts();
	}
	public function load_settings(): sv_lightbox {
		$this->get_setting( 'activate' )
				->set_title( __( 'Enable Lightbox', 'sv100_companion' ) )
				->set_description( __( 'Links to Images will be opened in a Lightbox', 'sv100_companion' ) )
				->load_type( 'checkbox' );

		return $this;
	}
	protected function register_scripts(): sv_lightbox{
		if($this->get_setting( 'activate' )->get_data()) {
			$this->get_script('lightbox')
				->set_path('lib/frontend/css/basicLightbox.min.css')
				->set_is_enqueued();

			$this->get_script('lightbox_js')
				->set_type('js')
				->set_path('lib/frontend/js/basicLightbox.min.js')
				->set_is_enqueued();

			$this->get_script('default_js')
				->set_type('js')
				->set_deps(array($this->get_script('lightbox_js')->get_handle()))
				->set_path('lib/frontend/js/default.js')
				->set_is_enqueued();
		}
		return $this;
	}
}