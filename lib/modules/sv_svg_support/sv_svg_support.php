<?php
namespace sv100_companion;

class sv_svg_support extends modules {
	public function init() {
		// Module Info
		$this->set_section_title( __('SVG Support','sv100_companion') );
		$this->set_section_desc( sprintf(__( 'This module loads styles of plugin %sSVG Support%s inline to improve Pagespeed.', 'sv100_companion' ),'<a href="https://de.wordpress.org/plugins/svg-support/" target="_blank">','</a>' ))
		->set_section_type( 'settings' )
		->load_settings()
		->get_root()->add_section($this);
		
		// WP Styles
		add_action( 'wp_print_styles', array($this, 'wp_print_styles'), 100 );
		add_action('wp', array($this, 'load'));
	}
	public function wp_print_styles() {
		if(defined('BODHI_SVGS_PLUGIN_PATH')) {
			// load Styles inline for Pagespeed purposes
			wp_dequeue_style('bodhi-svgs-attachment');
		}
	}
	protected function register_scripts(): sv_svg_support {
		$this->get_script('bodhi-svgs-attachment')
							->set_path( BODHI_SVGS_PLUGIN_PATH . 'css/svgs-attachment.css', true)
							->set_inline( true );
		
		return $this;
	}
	public function load() : sv_svg_support{
		if(defined('BODHI_SVGS_PLUGIN_PATH') && $this->get_setting('load_inline')->get_data()) {
			$this->register_scripts();
			$this->get_script('bodhi-svgs-attachment')->set_is_enqueued( true );
		}
		
		return $this;
	}
	public function load_settings(): sv_svg_support{
		$this->get_setting('load_inline')
			 ->set_title( __( 'Load Styles inline.', 'sv100_companion' ) )
			 ->load_type( 'checkbox' );
		
		return $this;
	}
}