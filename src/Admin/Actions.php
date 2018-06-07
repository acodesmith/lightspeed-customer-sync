<?php


namespace LightspeedCustomerSync\Admin;


use LightspeedCustomerSync\API\Customer;
use LightspeedCustomerSync\API\Request;

class Actions {

	public function __construct() {

		add_action( 'wp_ajax_lightspeed_customer_sync', [ $this, 'sync' ] );
	}

	public function render($data) {

		header('Content-Type: application/json');
		echo json_encode($data);

		wp_die();
	}

	public function sync() {

		$step = isset($_REQUEST['step']) ? $_REQUEST['step'] : false;

		switch($step) {
			case 'start':
				$this->render( Customer::start() );
				break;
			default:
				$this->render([
					'success' => false,
					'error' => 'No step passed via the $_REQUEST object.'
				]);
		}

	}
}