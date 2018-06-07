<?php


namespace LightspeedCustomerSync\API;

/**
 * Class Customer
 * @package LightspeedCustomerSync\API
 *
 * @example response
 * {
 *      "@attributes": {
 *      "count": "8",
 *      "offset": "0",
 *      "limit": "100"
 * },
 * "Customer": [
 * {
 *      "firstName": "Alex",
 *      "lastName": "Lugo",
 *      "title": "",
 *      "company": "Lightspeed HQ",
 *      "companyRegistrationNumber": "",
 *      "vatNumber": "",
 *      "creditAccountID": "0",
 *      "customerTypeID": "2",
 *      "discountID": "0",
 *      "taxCategoryID": "0",
 *      "customerID": "1",
 *      "createTime": "2016-06-06T18:04:35+00:00",
 *      "timeStamp": "2016-09-09T14:13:13+00:00",
 *      "archived": "false"
 * },
 */
class Customer {

	public static function start() {

		$api = Request::instance( new Auth() );

		return $api->get('Customers');
	}
}