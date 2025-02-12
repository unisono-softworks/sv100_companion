<?php
	namespace sv100_companion;

	class sv_maintenance extends modules {
		public function init() {
			// Section Info
			$this->set_section_title( __( 'Maintenance', 'sv100_companion' ) )
				->set_section_desc( __( 'Improve Maintenance', 'sv100_companion' ) )
				->set_section_type( 'settings' );

			$this->get_root()->add_section($this);

			$this->load_settings();

			if($this->get_setting('recovery_mode_email')->get_data()){
				if(!defined('RECOVERY_MODE_EMAIL')) {
					define('RECOVERY_MODE_EMAIL', $this->get_setting('recovery_mode_email')->get_data());
				}else{
					error_log(__('SV100 Companion Notice: Recovery Mode Email could not have been set, as it was already set before.', 'sv100_companion'));
				}
			}
		}
		public function load_settings(): sv_maintenance{
			$this->get_setting('recovery_mode_email')
				->set_title( __( 'Recovery Mode Email', 'sv100_companion' ) )
				->set_description( __( 'Maintenance E-Mails will be send to this address.', 'sv100_companion' ) )
				->load_type( 'email' );

			return $this;
		}
	}