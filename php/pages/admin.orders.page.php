<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 750) {
		$core = Core::getInstance();
		$control = $core->getControl();

		if (isset($_POST['action']) && isset($_POST['id'])) {
			if ($_POST['action'] == 'finish') {
				$control->finishOrder((int) htmlspecialchars($_POST['id']));
				if (isset($_POST['noreturn'])) {
					exit(0);
				}
			} else if ($_POST['action'] == 'remove') {
				$control->removeOrder((int) htmlspecialchars($_POST['id']));
				header('Location: .');
			}
		}

		$idsel = '';
		$es = array('', 's=10&e=10');
		$sql = 'SELECT orders.id_order, time, SUM(count), SUM(count * IFNULL(discount_price, price)), name, surname, finished FROM orders NATURAL JOIN order_products ';
		$vals = array();
		if (isset($_GET['id'])) {
			$sql .= 'WHERE id_user = ? ';
			$vals[] = (int) htmlspecialchars($_GET['id']);
			$idsel = 'id=' . (int) htmlspecialchars($_GET['id']);
		}
		$sql .= 'GROUP BY id_order ORDER BY time DESC ';
		if (isset($_GET['s']) && isset($_GET['e'])) {
			$sql .= 'LIMIT ' . max((int) htmlspecialchars($_GET['s']), 0) . ', '. max((int) htmlspecialchars($_GET['e']), 1);
			$es[0] = 's=' . (max((int) htmlspecialchars($_GET['s']) - 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
			$es[1] = 's=' . (max((int) htmlspecialchars($_GET['s']) + 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
		} else {
			$sql .= 'LIMIT 0, 10';
		}

		$orders = $core->getDatabase()->query($sql, $vals);

		if (empty($orders)) {
			$content .= '<h2>Žádné další objednávky</h2>';
		} else {
			foreach ($orders as $v) {
				$name = '';
				if ($v[4] != null) {
					$name = $v[4] . ' ' . $v[5];
				}
				$content .= '<a href="uzivatel/objednavka/index.php?id=' . $v[0] . '" class="nolink">
					<article class="order">
					<h3>' . $v[0] . '</h3>
					<p class="order-time">' . date(DATE_GENERAL_FORMAT, strtotime($v[1])) . '</p>
					<p class="order-user">' . $name . '</p>
					<section class="order-prices">
					<p class="order-count">Počet položek: ' . $v[2] . '</p>
					<p class="order-full">Cena celkem: ' . number_format($v[3], 2, ',', '') . ' Kč</p>
					<p class="order-full" class="finished" data-id="' . $v[0] . '">Odeslána: ' . ($v[6] == 1 ? 'Ano' : 'Ne') . '</p>
					<section class="user-buttons">
					<button class="fullfill" data-id="' . $v[0] . '" data-finished="' . $v[6] . '">' . ($v[6] == 1 ? 'Vzít zpět' : 'Odeslat') . '</button>
					<form action="administrace/objednavky/index.php" method="POST" class="remOrder">
					<input type="hidden" name="action" value="remove">
					<input type="hidden" name="id" value="' . $v[0] . '">
					<input type="submit" value="Odebrat">
					</form>
					</section>
					</section>
					</article>
				</a>';
			}
			
		}
		$content .= '<div class="nav-buttons"><button onclick="location.href = &quot;administrace/objednavky?' . $idsel . $es[0] . '&quot;">←</button><button onclick="location.href = &quot;administrace/objednavky?' . $idsel . $es[1] . '&quot;">→</button></div>';
	} else {
		header('Location: ../../login');
		exit(1);
	}
} else {
	header('Location: ../../login');
	exit(1);
}

?>
