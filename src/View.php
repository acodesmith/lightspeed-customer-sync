<?php


namespace LightspeedCustomerSync;


class View {

	public static function render($file, $data = []) {

		$fullpath = LIGHTSPEED_CUSTOMER_SYNC_PATH . "views/$file.php";

		if( file_exists( $fullpath ) ) {

			extract($data);
			include $fullpath;
		}else{
			error_log("Trying to render unknown file: $fullpath");
		}
	}
}