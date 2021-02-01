<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '<h2 class="finish-order red b">Nepodařilo se vložit objednávku</h2>';

if (isset($_SESSION['cart']) && isset($_SESSION['order'])) {
	if (!empty($_SESSION['cart']) && !empty($_SESSION['order'])) {
		$core = Core::getInstance();
		$control = $core->getControl();

		$order = $control->insertOrder($_SESSION['order'], $_SESSION['cart']);

		if ($order !== null) {
			$content = '<h2 class="finish-order">Vytvořena objednávka: ' . $order->getId() . '</h2>';
		}

	} else {
		header('Location: ..');
	}
} else {
	header('Location: ..');
}

?>
