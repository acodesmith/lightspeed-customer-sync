<?php


namespace LightspeedCustomerSync\Admin;

use LightspeedCustomerSync\API\Auth;
use LightspeedCustomerSync\View;

/**
 * Class Page
 * @package LightspeedCustomerSync\Admin
 */
class Page {

	const MENU_SLUG = 'lightspeed-customer-sync';

	public function __construct() {

		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		add_action( 'init', [ $this, 'save_settings_page' ] );
		add_action('admin_enqueue_scripts', [ $this, 'scripts' ]);
	}

	/**
	 * Enqueue Admin Script
	 */
	public function scripts() {

		if( isset( $_GET['page'] ) && $_GET['page'] === self::MENU_SLUG ) {
			wp_enqueue_script(
				'lightspeed-customer-sync',
				LIGHTSPEED_CUSTOMER_SYNC_URL . 'assets/scripts/lightspeed-customer-sync.js',
				['jquery'],
				'0.0.1',
				true
			);
		}
	}

	/**
	 * Register the admin submenu page
	 */
	public function add_menu() {

		add_submenu_page(
			'tools.php',
			'Lightspeed Customer Sync',
			'Lightspeed Customer Sync',
			'edit_posts',
			self::MENU_SLUG,
			function () {
				self::view();
			} );
	}

	/**
	 * Render the admin settings and sync page
	 */
	public static function view() {

		$client_id         = \get_option( Auth::CLIENT_ID);
		$client_secret     = \get_option( Auth::CLIENT_SECRET );
		$display_auth_form = isset($_GET['display']) ? $_GET['display'] : 'admin--sync';


		if( ! empty($client_id) && ! empty($client_secret) && $display_auth_form !== 'admin--settings' )
			$display_auth_form = 'admin--sync';

		View::render( $display_auth_form, [
			'client_id'     => $client_id,
			'client_secret' => $client_secret
		] );
	}

	/**
	 * Save the admin settings form data
	 */
	public function save_settings_page() {

		// Validate form data before saving.
		if ( isset( $_POST['lightspeed_customer_sync_client_id'] )
		     && isset( $_POST['lightspeed_customer_sync_client_secret'] )
		     && isset( $_POST['lightspeed_customer_sync_nonce'] )
		     && wp_verify_nonce( $_POST['lightspeed_customer_sync_nonce'], 'lightspeed_customer_sync_nonce' ) ) {

			// Confirm the uses didn't submit the redacted data.
			if ( strpos( '**', $_POST['lightspeed_customer_sync_client_id'] )
			     && strpos( '**', $_POST['lightspeed_customer_sync_client_secret'] ) ) {
				// trying to save redacted data.
			} else {
				\update_option( Auth::CLIENT_ID, $_POST['lightspeed_customer_sync_client_id'] );
				\update_option( Auth::CLIENT_SECRET, $_POST['lightspeed_customer_sync_client_secret'] );
			}

			wp_redirect( 'tools.php?page=lightspeed-customer-sync&display=sync' );
		}
	}
}