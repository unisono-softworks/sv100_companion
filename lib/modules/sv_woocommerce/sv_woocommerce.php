<?php
	namespace sv100_companion;

	class sv_woocommerce extends modules {
		public function init() {
			// Module Info
			$this->set_section_title( __('WooCommerce','sv100_companion') )
				->set_section_desc( __('Tweaks', 'sv100_companion') )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section($this);

			if(strlen($this->get_setting('asset_loading')->get_data()) > 0 ) {
				add_action('template_redirect', array($this, 'template_redirect'), 999);
				add_action('wp_enqueue_scripts', array($this, 'frontend'), 1);
				add_action('enqueue_block_assets', array($this, 'backend'), 1);
			}
		}
		public function load_settings(): sv_woocommerce{
			$this->get_setting('asset_loading')
				->set_title( __( 'Scripts & Styles Loading', 'sv100_companion' ) )
				->set_options(array(
					''          => __( 'Default', 'sv100_companion' ),
					'demand'    => __( 'load on demand', 'sv100_companion' ),
					'none'      => __( 'load nothing', 'sv100_companion' ),
				))
				->load_type( 'select' );

			$this->get_setting('asset_loading_bypass_cart')
			     ->set_title( __( 'Cart Page: Bypass Loading Setting', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );

			$this->get_setting('asset_loading_bypass_checkout')
			     ->set_title( __( 'Checkout Page: Bypass Loading Setting', 'sv100_companion' ) )
			     ->load_type( 'checkbox' );

			return $this;
		}
		public function template_redirect(): sv_woocommerce {
			if (! is_plugin_active('woocommerce/woocommerce.php') && ! is_plugin_active_for_network('woocommerce/woocommerce.php')) {
				return $this;
			}

			// Skip Woo Pages
			if (
				$this->get_setting('asset_loading')->get_data() === 'demand'
				&& (
					is_woocommerce() || is_cart() || is_checkout() || is_account_page()
				)
			) {
				return $this;
			}

			if(function_exists('is_cart') && is_cart() && $this->get_setting('asset_loading_bypass_cart')->get_data()){
				return $this;
			}

			if(function_exists('is_checkout') && is_checkout() && $this->get_setting('asset_loading_bypass_checkout')->get_data()){
				return $this;
			}

			// Otherwise...
			remove_action('wp_enqueue_scripts', array(\WC_Frontend_Scripts::class, 'load_scripts'));
			remove_action('wp_print_scripts', array(\WC_Frontend_Scripts::class, 'localize_printed_scripts'), 5);
			remove_action('wp_print_footer_scripts', array(\WC_Frontend_Scripts::class, 'localize_printed_scripts'), 5);

			$this->common();

			return $this;
		}
		public function frontend(): sv_woocommerce {
			if(is_admin()){
				return $this;
			}

			if(function_exists('is_cart') && is_cart() && $this->get_setting('asset_loading_bypass_cart')->get_data()){
				return $this;
			}

			if(function_exists('is_checkout') && is_checkout() && $this->get_setting('asset_loading_bypass_checkout')->get_data()){
				return $this;
			}

			if($this->get_setting('asset_loading')->get_data() === 'demand'){
				$block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();
				foreach ( $block_types as $block_type ) {
					if(strpos($block_type->name, 'woocommerce/') !== false){
						if($this->has_block_frontend($block_type->name)){
							return $this;
						}
					}
				}
			}

			$this->common();

			return $this;
		}
		public function backend(): sv_woocommerce {
			wp_deregister_style( 'wc-block-editor' );

			$this->common();

			return $this;
		}
		public function common(): sv_woocommerce{
			wp_dequeue_style( 'wc-blocks-style' );
			wp_dequeue_style( 'woocommerce-inline' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce_frontend_styles' );
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_style( 'woocommerce-blocktheme' );
			wp_dequeue_style( 'photoswipe-default-skin' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );
			wp_dequeue_script( 'flexslider' );
			wp_dequeue_script( 'zoom' );
			wp_dequeue_script( 'photoswipe' );
			wp_dequeue_script( 'photoswipe-ui-default' );

			return $this;
		}
	}