<?php
/**

@package Lightspeed Customer Sync

Plugin Name: Lightspeed Customer Sync
Plugin URI: https://github.com/acodesmith/lightspeed-customer-sync
Description: Sync Lightspeed customers into the wp_users table. Does not sync WooCommerce orders!
Version: 1.0.0
Author: ACODESMITH
Author URI: https://acodesmith.com
Text Domain: acodesmith
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/** Composer Autoloader */
require_once 'vendor/autoload.php';

use KHO\Fabric\Components;
use KHO\Fabric\Models\Products;
use KHO\Fabric\Models\LandingPages;
use KHO\Fabric\Models\Wiki;
use KHO\Fabric\Queries\Products as ProductQueries;
use KHO\Fabric\Modules;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function kho_fabric_run()
{
	/** Define CONST for loading and reference file locations */
	if( ! defined('KHO_FABRIC_URL') ) define( 'KHO_FABRIC_URL', plugin_dir_url( __FILE__ ) );
	if( ! defined('KHO_FABRIC_PATH') ) define( 'KHO_FABRIC_PATH', plugin_dir_path( __FILE__ ) );

	/** Global Assets */
	new Components\Assets();

	/** Custom Post Type and Custom Taxonomy Bootstrapping */
	new Products\Bootstrap();
	new LandingPages\Bootstrap();
	new Wiki\Bootstrap();

	/** Queries Interactions */
	new ProductQueries\Search();
	new ProductQueries\LandingPages();

	/** MODULES */

	/** WooCommerce Overrides and Integrations */
	new Modules\WooCommerce\Bootstrap();

	/** Tooltips */
	new Modules\HelpGuides\Bootstrap();

	/** Search Facets */
	new Modules\Search\Facets();

}

kho_fabric_run();

/**
 * Global content is used by other third party plugins which don't respect namespace loading
 */
function kho_load_wc_global_content()
{
	include 'src/Modules/WooCommerce/PaymentGateways/WC_Gateway_Approvals.php';

	add_filter( 'gform_notification_1', 'kho_gform_notification_signature', 10, 3 );
}
add_action('plugins_loaded', 'kho_load_wc_global_content');