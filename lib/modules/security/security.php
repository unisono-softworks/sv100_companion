<?php
	namespace sv100_companion;

	class security extends modules {
		public function init() {
			// Module Info
			$this->set_section_title( __('Security','sv100_companion') )
				->set_section_desc( __('Tweaks', 'sv100_companion') )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section($this);

			if($this->get_setting('disable_rest_users_endpoint')->get_data()) {
				// Disable /users rest routes
				add_filter('rest_endpoints', function( $endpoints ) {
					if ( isset( $endpoints['/wp/v2/users'] ) ) {
						unset( $endpoints['/wp/v2/users'] );
					}
					if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
						unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
					}
					return $endpoints;
				});
			}
		}
		public function load_settings(): security{
			$this->get_setting('disable_rest_users_endpoint')
				->set_title( __( 'Disable Rest Users Endpoint', 'sv100_companion' ) )
				->set_description( __( '/wp-json/wp/v2/users will return 404 instead of a list of wp users.', 'sv100_companion' ) )
				->load_type( 'checkbox' );

			return $this;
		}
	}