<?php

/**
 * Fired during plugin activation
 *
 * @link       https://hub.com/
 * @since      0.1.0
 *
 * @package    Hub_Woocommerce
 * @subpackage Hub_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Hub_Woocommerce
 * @subpackage Hub_Woocommerce/includes
 * @author     Twerlo <support@twerlo.com>
 */
class Hub_Woocommerce_Activator
{

	/**
	 * Install merchant in hub backend and register events webhooks in woo
	 *
	 * @since    0.1.0
	 */
	public static function activate()
	{

		Hub_Woocommerce_Activator::install_merchant();
		Hub_Woocommerce_Activator::register_webhooks();
	}

	// if not there request new merchant install from hubs
	private static function install_merchant()
	{
		$store_id = update_option('store_id', wp_generate_uuid4());

		$store_data = array(
			'event_name' => 'install',
			'store_name' => get_bloginfo('name'),
			'store_phone' => get_option('admin_phone'),
			'store_email' => get_option('admin_email'),
			'store_url' => get_bloginfo('url'),
			'store_id' =>get_option('store_id', ''),
		);

		// Set up the request arguments
		$args = array(
			'body'        => json_encode($store_data),
			'headers'     => array(
				'Content-Type' => 'application/json',
			),
			'timeout'     => 15,
		);

		$request_url = 'https://01hsaz5r26g79f7ewpc5gjpf4j10-931d83797b9bc62026f0.requestinspector.com';
		$response = wp_remote_post($request_url, $args);

		// Check for errors
		if (is_wp_error($response)) {
			echo 'Error: ' . $response->get_error_message();
		} else {
			// Success, save integration_id
			$body = wp_remote_retrieve_body($response);
			echo 'Response: ' . $body;
			error_log($body);

			$responseArray = json_decode($body, true);
			// $integration_id = $responseArray['merchantDetails']['_id'];
			// if ($integration_id) {
			// }
		}
	}

	private static function register_webhooks()
	{
		$webhooks_topics_to_register = [
			'order.created',
			'order.updated',
			'order.deleted',
			'order.restored',
			'product.created',
			'product.updated',
			'product.deleted',
			'customer.created',
			'customer.updated',
			'customer.deleted',
			'coupon.created',
			'coupon.updated',
			'coupon.deleted'
		];

		// not required though, it is just for webhook secret
		$consumer_key = 'YOUR_CONSUMER_KEY';
		$consumer_secret = 'YOUR_CONSUMER_SECRET';

		// Set the webhook status to 'active'
		$webhook_status = 'active';

		// Set the webhook endpoint URL
		$webhook_url = 'https://01hsaz5r26g79f7ewpc5gjpf4j10-931d83797b9bc62026f0.requestinspector.com' . '?itegration_id=' . get_option('hub_integration_id');

		foreach ($webhooks_topics_to_register as $webhook_topic) {
			// Create the webhook data
			$webhook_data = array(
				'name' => 'Hub Event: ' . $webhook_topic,
				'topic' => $webhook_topic,
				'delivery_url' => $webhook_url,
				'status' => $webhook_status,
				'api_version' => 'v3',
				'secret' => wc_api_hash($consumer_key . $consumer_secret),
				'user_id' => get_current_user_id(),
			);

			// Create a new WC_Webhook instance
			$webhook = new WC_Webhook();

			// Set the webhook data
			$webhook->set_props($webhook_data);

			// Save the webhook
			$webhook->save();
		}
	}
}
