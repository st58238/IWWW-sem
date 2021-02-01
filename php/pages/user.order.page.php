<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '<h2 class="red">' . backButton() . 'Objednávka neexistuje.</h2>';
$oid = '';

if (isset($_SESSION['user']) && isset($_GET['id'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && !empty($_GET['id'])) {
		$core = Core::getInstance();
		$control = $core->getControl();
		$oid = htmlspecialchars($_GET['id']);
		$o = $control->getOrderById($oid);

		if ($o === null || !($_SESSION['user']->getId() !== $o->getUser() || $_SESSION['user']->getRole() >= 500)) {
			
		} else {
			$u = $control->getUserById($o->getUser());
			$count = 0;
			$sum = 0;

			$content = '<h1 class="page-title">' . backButton(null, 'uzivatel/mojeobjednavky') . 'Objednávka ' . $oid . '</h1><section class="cart-items">';

			$prods = $core->getDatabase()->query('SELECT id_product, count FROM order_products WHERE id_order = ?', [$oid]);

			foreach ($prods as $pair) {
				$p = $core->getControl()->getProductById($pair[0]);
				$count += $pair[1];
				$sum += $p->getCorrectPrice() * $pair[1];

				$content .= '
					<article class="cart-item">
						<a class="cart-link nolink" href="produkt/index.php?id=' . $p->getId() . '">
							<h2 class="cart-name">' . $p->getName() . '</h2>
						</a>
						<a class="cart-link nolink cart-image-link-container" href="produkt/index.php?id=' . $p->getId() . '">
							<div class="cart-image-container">
								<img class="cart-image" src="img/eshop/' . $p->getImg() . '" alt="'. $p->getImg() . '">
							</div>
						</a>
						<p class="cart-stock">' . ($p->getStock() ? '<span class="green">Skladem</span>' : '<span class="red">Není skladem</span>') . '</p>

						<p class="cart-price">' . $p->getFullPrice() . '</p>
						<p class="confirm-count">Počet: ' . $pair[1] . ' ' . $p->getUnit() . '</p>
						<p class="confirm-novat">Bez DPH: ' . number_format(nonVAT($p->getCorrectPrice() * $pair[1]), 2, ',', '') . ' Kč</p>
						<p class="confirm-vat">DPH: ' . number_format(VAT($p->getCorrectPrice() * $pair[1]), 2, ',', '') . ' Kč' . $p->getUnit() . '</p>
						<p class="confirm-full">Cena celkem: ' . number_format($p->getCorrectPrice() * $pair[1], 2, ',', '') . ' Kč</p>
					</article>
					<hr />
				';
			}

			if ($o->getDelivery() == 0) {
				$content .= DELIVERY_CP[0];
				$sum += DELIVERY_CP[1];
			} else if ($o->getDelivery() == 1) {
				$content .= DELIVERY_PPL[0];
				$sum += DELIVERY_PPL[1];
			} else if ($o->getDelivery() == 2) {
				$content .= DELIVERY_OS[0];
				$sum += DELIVERY_OS[1];
			} else {
				die(-1);
			}

			$content .= '<hr />';

			if ($o->getPayment() == 0) {
				if ($o->getDelivery() == 0) {
					$content .= PAYMENT_PPL[0];
					$sum += PAYMENT_PPL[1];
				} else if ($o->getDelivery() == 1) {
					$content .= PAYMENT_CP[0];
					$sum += PAYMENT_CP[1];
				} else {
					die(-1);
				}
			} else if ($o->getPayment() == 1) {
				$content .= PAYMENT_BANK[0];
				$sum += PAYMENT_BANK[1];
			} else if ($o->getPayment() == 0) {
				$content .= PAYMENT_OS[0];
				$sum += PAYMENT_OS[1];
			} else {
				die(-1);
			}

			$content .= '<hr />';

			$content .= '<section class="confirm-info"><section class="confirm-addr">
				<h3>Fakturační adresa</h3>
				<p class="confirm-name">' . $o->getName() . ' ' . $o->getSurname() . '</p>
				<p class="confirm-name">' . $o->getEmail() . '</p>
				<p class="confirm-name">' . $o->getPhone() . '</p>
				<p class="confirm-name">' . $o->getStreet() . ', ' . $o->getZip() . ' ' . $o->getCity() . '</p>
				<p class="confirm-name">' . COUNTRIES[(int) $o->getCountry()] . '</p>
			</section>';

			$altAddr = $control->getAltAddress($oid);

			if ($altAddr != null && $altAddr->isValid()) {
				$content .= '<section class="confirm-alt-addr">
					<h3>Doručit na adresu:</h3>
					<p class="confirm-name">' . $altAddr->getStreet() . ', ' . $altAddr->getZip() . ' ' . $altAddr->getCity() . '</p>
					<p class="confirm-name">' . COUNTRIES[(int) $altAddr->getCountry()] . '</p>
				</section>';

			} else {
				$content .= '<section class="confirm-alt-addr"></section>';
			}

			$content .= '<section class="confirm-sum">
				<h3>Souhrn cen</h3>
				<p class="confirm-sum-count">Počet položek: ' . $count . '</p>
				<p class="confirm-sum-novat">Bez DPH celkem: ' . number_format(nonVAT($sum), 2, ',', '') . ' Kč</p>
				<p class="confirm-sum-nvat">DPH celkem: ' . number_format(VAT($sum), 2, ',', '') . ' Kč</p>
				<p class="b">Cena celkem: ' . number_format($sum, 2, ',', '') . ' Kč</p>
			</section></section>';

			$content .= '</section>	';
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
