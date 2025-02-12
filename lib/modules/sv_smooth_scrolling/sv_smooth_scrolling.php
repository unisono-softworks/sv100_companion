<?php
namespace sv100_companion;

class sv_smooth_scrolling extends modules {
	public function init() {
		$this->load_settings()
			->register_scripts()
			->set_section_title( __( 'Smooth Scrolling', 'sv100_companion' ) )
			->set_section_desc( __( 'Slide to Anker', 'sv100_companion' ) )
			->set_section_type( 'settings' )
			->get_root()
			->add_section( $this );
	}
	public function register_scripts(): sv_smooth_scrolling{
		// Loads Scripts
		if($this->get_setting( 'activate' )->get_data()) {
			$this->get_script('frontend')
				->set_path('lib/js/frontend.js')
				->set_type('js')
				->set_localized(['offset'=>$this->get_setting('offset')->get_data()])
				->set_is_enqueued();

			add_filter( 'rocket_delay_js_exclusions', function ( $excluded_files = array() ) {
				$excluded_files[] = $this->get_name();

				return $excluded_files;
			} );
		}

		return $this;
	}
	public function load_settings(): sv_smooth_scrolling{
		$this->get_setting( 'activate' )
			->set_title( __( 'Activate', 'sv100_companion' ) )
			->set_description( __( 'Activate Smooth Scrolling.', 'sv100_companion' ) )
			->load_type( 'checkbox' );

		$this->get_setting( 'offset' )
		     ->set_title( __( 'Offset', 'sv100_companion' ) )
		     ->set_description( __( 'Set the offset in pixels between target elements and scroll target.', 'sv100_companion' ) )
		     ->load_type( 'number' );

		return $this;
	}
}