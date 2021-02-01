<?php

// Loads everything from /system
require_once(__DIR__ . '/system.php');

// Loads everything from /model
require_once(__DIR__ . '/model.php');

// Load control module
require_once(__DIR__ . '/control.php');

sessionStart();

class Core {
	private static $db;
	private static $control;

	private static $core;

	static function getInstance(Database $db = null): Core {
		if (Core::$core === null) {
			Core::$core = new Core($db);
		}
		return Core::$core;
	}

	private function __construct(Database $db = null) {
		if ($db == null) {
			Core::$db = new Database($db);
		} else {
			Core::$db = $db;
		}

		Core::$control = new Control(Core::$db);
	}

	function &getControl(): Control {
		return Core::$control;
	}

	function &getDatabase(): Database {
		return Core::$db;
	}

}

?>
