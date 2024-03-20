<?php

/**
 * Integration Hub Integration.
 *
 * @package  WC_Integration_Hub_Integration
 * @category Integration
 * @author   Patrick Rauland
 */
if (!class_exists('WC_Integration_Hub_Integration')) :
	/**
	 * Hub Integration class.
	 */
	class WC_Integration_Hub_Integration extends WC_Integration
	{
		public $store_id = "";
		public $hub_integration_url = "";

		/**
		 * Init and hook in the integration.
		 */
		public function __construct()
		{
			global $woocommerce;

			$this->id                 = 'integration-hub';
			$this->method_title       = __('Integration Hub', 'hub-woocommerce');
			$this->method_description = __('An integration hub to show you how easy it is to send WA notifications using hub.', 'hub-woocommerce');

			$this->platform_id = get_option('store_id');
			$this->hub_integration_url = "https://e6c5-102-186-40-102.ngrok-free.app/api/v1/integration/events/woocommerce/app.event" . get_option('store_id');

			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();

			// Define user set variables.
			$this->hub_integration_id = $this->get_option('store_id');

			// Actions.
			add_action('woocommerce_update_options_integration_' .  $this->id, array($this, 'process_admin_options'));
		}

		/**
		 * Initialize integration settings form fields.
		 */
		public function init_form_fields()
		{
			$this->form_fields = array(
				'store_id' => array(
					'title'       => __('Integration ID', 'hub-woocommerce'),
					'type'        => 'text',
					'description' => __('Use this ID in Hub Portal to control notification templates. <a href="' . $this->store_id . '" target="_blank">Hub Portal</a>.', 'hub-woocommerce'),
					'desc_tip'    => false,
					'default'     => $this->store_id,
					'custom_attributes' => array('readonly' => 'readonly')
				),
			);
		}
	}
endif;
