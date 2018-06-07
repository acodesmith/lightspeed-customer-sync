<?php


namespace LightspeedCustomerSync\API;

/**
 * Class Auth
 * @package LightspeedCustomerSync\API
 */
class Auth {

	const CLIENT_ID = 'lcs_cid';

	const CLIENT_SECRET = 'lcs_cs';

	const AUTH_TOKEN = 'lcs_token';

	const AUTH_ENDPOINT = 'https://cloud.lightspeedapp.com/oauth/authorize.php';

	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'oauth_redirect' ] );
	}

	/**
	 * @return array|bool|mixed|object
	 */
	public function get_oauth_token() {

		$data = \get_option( self::AUTH_TOKEN );

		return ! empty( $data ) ? json_decode( $data ) : false;
	}

	/**
	 * @param $code
	 *
	 * @return array
	 */
	public function request_access_token($code) {

		$client_id         = \get_option( self::CLIENT_ID );
		$client_secret     = \get_option( self::CLIENT_SECRET );

		$postFields = [
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
			'code'          => $code,
			'grant_type'    => 'authorization_code'
		];

		$curl = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => self::AUTH_ENDPOINT,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => $postFields
		) );

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if($err)
			return [
				'success' => false,
				'error' => $err
			];

		return [
			'success' => true,
			'response' => json_decode($response)
		];
	}

	/**
	 * Handle third party api redirect.
	 *
	 * `code` set by Lightspeed.
	 */
	public function oauth_redirect() {

		if ( ! empty( $_GET['lightspeed-customer'] ) && ! empty( $_GET['code'] ) ) {
			list($success, $data) = $this->request_access_token( $_GET['code'] );

			if($success) {
				\update_option(self::AUTH_TOKEN, json_encode(array_merge(['request_time' => time()], $data)));
			}else{
				// Handle error with redirect
				// @todo handle error
			}
		}
	}
}