<?php

require_once(__DIR__ . '/defines.lib.php');

class Debug {

	private function __construct() {}

	public static function debug($item): void {
		if (DEBUG === DEBUG_FULL) {
			if ($item instanceof Exception) {
				var_dump($item->getMessage());
			} else {
				var_dump($item);
			}
		} else if (DEBUG === DEBUG_PRINT) {
			if ($item instanceof Exception) {
				echo $item->getMessage();
			} else {
				echo $item;
			}
		} else if (DEBUG === DEBUG_NOTICE) {
			echo 'Error';
		} else if (DEBUG === DEBUG_NULL) {

		} else if (DEBUG !== DEBUG_FULL && DEBUG !== DEBUG_PRINT && DEBUG !== DEBUG_NULL) {
			echo 'DEBUG constant mismatch.';
		}
	}
}

// Global function wrapper -----------------------------------------------
function debug($item): void {
	Debug::debug($item);
}

?>