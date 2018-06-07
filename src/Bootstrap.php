<?php


namespace LightspeedCustomerSync;


use LightspeedCustomerSync\API\Auth;
use LightspeedCustomerSync\API\Request;

class Bootstrap {

	public function __construct() {
		new Admin\Page();
		new Admin\Actions();
	}
}