<?php
	namespace sv100_companion;

	class sv_gutenberg extends modules {
		public function init() {
			$this->load_settings()
			     ->set_section_title( __( 'Gutenberg', 'sv100_companion' ) )
			     ->set_section_desc( __( 'Gutenberg Enhancements', 'sv100_companion' ) )
			     ->set_section_type( 'settings' )
			     ->get_root()
			     ->add_section( $this );

			if($this->get_setting( 'remove_wp_render_layout_support_flag' )->get_data()){
				$this->remove_wp_render_layout_support_flag();
			}

			if($this->get_setting( 'remove_core_block_patterns' )->get_data()){
				$this->remove_core_block_patterns();
			}

			add_action('admin_init', function(){
				if(is_admin() && $this->get_setting( 'show_link_manage_reusable_blocks' )->get_data()) {
					add_menu_page( __( 'Reusable Blocks', 'sv100_companion' ), __( 'Reusable Blocks', 'sv100_companion' ),
						'read', 'edit.php?post_type=wp_block', '', '', 21 );
				}
			});
		}
		public function load_settings(): sv_gutenberg{
			$this->get_setting( 'show_link_manage_reusable_blocks' )
			     ->set_title( __( 'Reusable blocks admin menu entry', 'sv100_companion' ) )
			     ->set_description( __( 'Show manage reusable blocks link in backend menu.', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );

			$this->get_setting( 'remove_core_block_patterns' )
			     ->set_title( __( 'Remove core block patterns', 'sv100_companion' ) )
			     ->set_description( __( 'This remove the core block patterns from the pattern window in the editor. Useful if you want to show only custom patterns.', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );

			$this->get_setting( 'remove_wp_render_layout_support_flag' )
			     ->set_title( __( 'Remove WP render layout support flag', 'sv100_companion' ) )
			     ->set_description( __( 'Remove Custom Block CSS (.wp-containert-xxx)', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );
			
			return $this;
		}
		// @see https://fullsiteediting.com/lessons/how-to-remove-default-block-styles/#h-how-to-remove-the-inline-styles-on-the-front
		public function remove_wp_render_layout_support_flag(): sv_gutenberg{
			remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
			remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );

			return $this;
		}

		public function remove_core_block_patterns(): sv_gutenberg{
			remove_theme_support('core-block-patterns');
			return $this;
		}
	}
