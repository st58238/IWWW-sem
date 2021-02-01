<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 500) {
		$core = Core::getInstance();
		$control = $core->getControl();

		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'deleteProduct' && isset($_POST['id'])) {
				$control->deleteProduct((int) htmlspecialchars($_POST['id']));
			}
		}

		$es = array('', 's=10&e=10');
		$sql = 'SELECT name, picture, quantity, unit, stock, price, discount_price, display, id_product FROM products ';
		$vals = array();

		if (isset($_GET['s']) && isset($_GET['e'])) {
			$sql .= 'LIMIT ' . max((int) htmlspecialchars($_GET['s']), 0) . ', '. max((int) htmlspecialchars($_GET['e']), 1);
			$es[0] = 's=' . (max((int) htmlspecialchars($_GET['s']) - 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
			$es[1] = 's=' . (max((int) htmlspecialchars($_GET['s']) + 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
		} else {
			$sql .= 'LIMIT 0, 10';
		}

		$orders = $core->getDatabase()->query($sql, $vals);

		if (empty($orders)) {
			$content .= '<h2>Žádné další produkty</h2>';
		} else {
			foreach ($orders as $v) {
				$name = '';
				if ($v[4] != null) {
					$name = $v[4] . '&nbsp;' . $v[5];
				}
				$content .= '<a href="administrace/produkt/index.php?id=' . $v[8] . '" class="nolink">
					<article class="order">
					<h3>' . $v[0] . '</h3>
					<div class="product-image"><img src="img/eshop/' . $v[1] . '" alt=""></div>
					<p class="order-user">' . number_format($v[5], 2, ',', '') . ' Kč/' . $v[2] . '&nbsp;' . $v[3] . '</p>
					<p class="order-disc">Zlevněno' . ($v[6] == null ? ': Ne' : (' na ' . number_format($v[5], 2, ',', '') . ' Kč/' . $v[2] . '&nbsp;' . $v[3])) . '</p>
					<p class="order-user">V prodeji: ' . ($v[7] == 1 ? 'Ano' : 'Ne' ) . '</p>

					<section class="user-buttons order-prices">
					<form class="user-button" action="administrace/produkt/index.php" method="GET">
					<input type="hidden" name="id" value="' . $v[8] . '">
					<input type="submit" value="Upravit">
					</form>
					<form class="user-button" action="administrace/produkty/index.php" method="POST">
					<input type="hidden" name="action" value="deleteProduct">
					<input type="hidden" name="id" value="' . $v[8] . '">
					<input type="submit" value="' . ($v[7] == 1 ? 'Stáhnout z prodeje' : 'Navrátit do prodeje') . '">
					</form>
					</section>
					</article>
				</a>';
			}
			
		}
		$content .= '<div class="nav-buttons"><button onclick="location.href = &quot;administrace/produkty?' . $es[0] . '&quot;">←</button><button onclick="location.href = &quot;administrace/produkty?' . $es[1] . '&quot;">→</button></div>';
	} else {
		header('Location: ../../login');
		exit(1);
	}
} else {
	header('Location: ../../login');
	exit(1);
}

?>
