<?php


namespace LightspeedCustomerSync\API;


class Request {

	const BASE_ENDPOINT = "https://api.lightspeedapp.com/API/";

	/**
	 * @var \LightspeedCustomerSync\API\Request
	 */
	private static $_instance = null;

	/**
	 * @var \LightspeedCustomerSync\API\Auth
	 */
	private static $_auth;

	public static $accountID = null;

	public function __construct($auth = null) {

		if( ! empty( $auth ) )
			self::$_auth = $auth;
	}

	public static function instance($auth = null) {

		if( ! self::$_instance )
			self::$_instance = new self($auth);

		return self::$_instance;
	}

	public function get($endpoint) {

		if( empty( self::$_auth ) )
			return 'Missing authentication class. Should have been passed in on class construction.';

		$auth_token_data = self::$_auth->get_oauth_token();

		if( ! $auth_token_data )
			return 'Missing authentication token. Please confirm client id and client secret are set.';

		$curl = curl_init();

		// https://api.lightspeedapp.com/API/Account/{accountID}/Customer.json
		curl_setopt_array($curl, [
			CURLOPT_URL => self::BASE_ENDPOINT . 'Account/' . self::$accountID . '/' . $endpoint . ".json",
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer {access_token}",
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		}

		return $response;
	}
}