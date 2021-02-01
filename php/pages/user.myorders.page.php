<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null) {
		$core = Core::getInstance();
		$control = $core->getControl();
		
		$orders = $core->getDatabase()->query('SELECT id_order, time, SUM(count), SUM(count * IFNULL(discount_price, price)) FROM orders NATURAL JOIN order_products WHERE id_user = ? GROUP BY id_order', [$_SESSION['user']->getId()]);
		if (empty($orders)) {
			$content .= '<h2>Žádné objednávky</h2>';
		} else {
			foreach ($orders as $v) {
				$content .= '<a href="uzivatel/objednavka/index.php?id=' . $v[0] . '" class="nolink">
					<article class="order">
					<h3>' . $v[0] . '</h3>
					<p class="order-time">' . date(DATE_GENERAL_FORMAT, strtotime($v[1])) . '</p>
					<section class="order-prices">
					<p class="order-count">Počet položek: ' . $v[2] . '</p>
					<p class="order-nonvat">Bez DPH: ' . number_format(nonVAT($v[3]), 2, ',', '') . ' Kč</p>
					<p class="order-vat">DPH: ' . number_format(VAT($v[3]), 2, ',', '') . ' Kč</p>
					<p class="order-full">Cena celkem: ' . number_format($v[3], 2, ',', '') . ' Kč</p>
					</section>
					</article>
				</a>';
			}
		}
	} else {
		header('Location: ../login');
		exit(1);
	}
} else {
	header('Location: ../login');
	exit(1);
}

?>
