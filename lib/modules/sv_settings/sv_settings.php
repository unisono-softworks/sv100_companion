<?php
	namespace sv100_companion;

	class sv_settings extends init {

		public function init() {
			$this
				->set_section_title( __( 'SV Settings Import/Export', 'sv100_companion' ) )
				->set_section_desc( __( 'Import and export settings from SV theme and plugins', 'sv100_companion' ) )
				->set_section_type( 'tools' )
				->set_section_template_path( $this->get_path( 'lib/backend/tpl/tools.php' ) )
				->register_scripts()
				->get_root()
				->add_section( $this );
            //$this->delete_options();
			// Action Hooks
			add_action( 'wp_ajax_' . $this->get_prefix( 'export' ) , array( $this, 'settings_export' ) );
			add_action( 'wp_ajax_' . $this->get_prefix( 'reset' ), array( $this, 'settings_reset' ) );
			add_action( 'wp_ajax_' . $this->get_prefix( 'import' ), array( $this, 'settings_import' ) );

        }

		protected function register_scripts(): sv_settings {
			// Register Styles
			$this->get_script( 'tools' )
				 ->set_path( 'lib/backend/css/tools.css' )
				 ->set_inline( true )
				 ->set_is_backend()
				 ->set_is_enqueued();

			return $this;
		}

		public function settings_reset() {
			if ( ! check_ajax_referer( $this->get_prefix( 'reset' ), 'nonce' ) ) return false;

			$this->delete_options();

			echo json_encode( array(
				'notice'	=> true,
				'msg' 		=> __( 'Successfully reseted all settings.', 'sv100_companion' ),
				'type'		=> 'success',
			));

			wp_die();
		}

		/* @todo template ajax button broken - needs support in core to catch up data after page load and add it to the payload */
        public function settings_import() {
            // Verify the AJAX nonce
            if ( ! check_ajax_referer( $this->get_prefix( 'import' ), 'nonce', false ) ) {
                wp_send_json_error( array(
                    'notice' => true,
                    'msg'    => __( 'Invalid nonce. Request not allowed.', 'sv100_companion' ),
                    'type'   => 'error',
                ) );
                wp_die();
            }

            if ( ! isset( $_POST['payload'] ) ) {
                wp_send_json_error( array(
                    'notice' => true,
                    'msg'    => __( 'No settings data provided.', 'sv100_companion' ),
                    'type'   => 'error',
                ) );
                wp_die();
            }

            $payload = is_string($_POST['payload']) ? json_decode( stripslashes_deep( $_POST['payload'] ), true ) :  $_POST['payload'];

            if ( ! $payload ) {
                wp_send_json_error( array(
                    'notice' => true,
                    'msg'    => __( 'Settings JSON corrupt.', 'sv100_companion' ),
                    'type'   => 'error',
                ) );
                wp_die();
            }

            // Build whitelist of allowed options (just the keys)
            $allowed_option_keys = array_keys( $this->get_allowed_settings_keys() );

            // Support both full and flat payloads
            $settings = isset( $payload['sv100_companion_sv_settings_all'] )
                ? ( is_string( $payload['sv100_companion_sv_settings_all'] )
                    ? json_decode( stripslashes_deep( $payload['sv100_companion_sv_settings_all'] ), true )
                    : $payload['sv100_companion_sv_settings_all']
                )
                : $payload;

            if ( is_array( $settings ) ) {
                foreach ( $settings as $option_id => $option_value ) {
                    if ( in_array( $option_id, $allowed_option_keys, true ) ) {
                        update_option( $option_id, $option_value, true );
                    }
                }
            }

            $this->get_script()->clear_cache();

            wp_send_json_success( array(
                'notice' => true,
                'msg'    => __( 'Settings imported successfully.', 'sv100_companion' ),
                'type'   => 'success',
            ) );

            wp_die();
        }


        private function delete_options() {
			foreach ( wp_load_alloptions() as $option => $value ) {
				if ( strpos( $option, 'sv100_sv_' ) === 0) {
					delete_option( $option );
				}
			}
		}

        private function get_allowed_settings_keys(){
            // Fetch current settings
            $current_settings = array();
            $instances = $this->get_instances(); // get all active instances

            foreach ( $instances as $instance ) {
                $module_settings = $instance->get_modules_settings();
                foreach ( $module_settings as $module_name => $settings ) {
                    $current_settings = array_merge( $current_settings, $settings );
                }
            }

            return $current_settings;
        }

    }