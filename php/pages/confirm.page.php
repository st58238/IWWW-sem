<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$cartItems = '<h3>Košík je prázdný.</h3>';
$sum = 0;
$count = 0;

if (isset($_SESSION['cart']) && isset($_POST)) {
	if (!empty($_SESSION['cart']) && !empty($_POST)) {
		$cartItems = '<section class="cart-items">';
		$core = Core::getInstance();

		foreach ($_SESSION['cart'] as $pair) {
			$p = $core->getControl()->getProductById($pair['id']);
			$count += $pair['count'];
			$sum += $p->getCorrectPrice() * $pair['count'];

			$cartItems .= '
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
					<p class="confirm-count">Počet: ' . $pair['count'] . '&nbsp;' . $p->getUnit() . '</p>
					<p class="confirm-novat">Bez DPH: ' . number_format(nonVAT($p->getCorrectPrice() * $pair['count']), 2, ',', '') . ' Kč</p>
					<p class="confirm-vat">DPH: ' . number_format(VAT($p->getCorrectPrice() * $pair['count']), 2, ',', '') . ' Kč/' . $p->getUnit() . '</p>
					<p class="confirm-full">Cena celkem: ' . number_format($p->getCorrectPrice() * $pair['count'], 2, ',', '') . ' Kč</p>
				</article>
				<hr />
			';
		}

		if ($_POST['delivery'] == 0) {
			$cartItems .= DELIVERY_CP[0];
			$sum += DELIVERY_CP[1];
		} else if ($_POST['delivery'] == 1) {
			$cartItems .= DELIVERY_PPL[0];
			$sum += DELIVERY_PPL[1];
		} else if ($_POST['delivery'] == 2) {
			$cartItems .= DELIVERY_OS[0];
			$sum += DELIVERY_OS[1];
		} else {
			die(-1);
		}

		$cartItems .= '<hr />';

		if ($_POST['payment'] == 0) {
			if ($_POST['delivery'] == 0) {
				$cartItems .= PAYMENT_PPL[0];
				$sum += PAYMENT_PPL[1];
			} else if ($_POST['delivery'] == 1) {
				$cartItems .= PAYMENT_CP[0];
				$sum += PAYMENT_CP[1];
			} else {
				//die(-1);
			}
		} else if ($_POST['payment'] == 1) {
			$cartItems .= PAYMENT_BANK[0];
			$sum += PAYMENT_BANK[1];
		} else if ($_POST['payment'] == 2) {
			$cartItems .= PAYMENT_OS[0];
			$sum += PAYMENT_OS[1];
		} else {
			die(-1);
		}

		$cartItems .= '<hr />';

		$_SESSION['order'] = [
			'name' => htmlspecialchars($_POST['name']), 
			'surname' => htmlspecialchars($_POST['surname']), 
			'email' => htmlspecialchars($_POST['email']), 
			'phone' => htmlspecialchars($_POST['phone']), 
			'street' => htmlspecialchars($_POST['street']), 
			'city' => htmlspecialchars($_POST['city']), 
			'zip' => (int) htmlspecialchars($_POST['zip']), 
			'country' => (int) htmlspecialchars($_POST['country']), 
			'alt-street' => htmlspecialchars($_POST['alt-street']), 
			'alt-city' => htmlspecialchars($_POST['alt-city']), 
			'alt-zip' => (int) htmlspecialchars($_POST['alt-zip']), 
			'alt-country' => (int) htmlspecialchars($_POST['alt-country']), 
			'delivery' => (int) htmlspecialchars($_POST['delivery']), 
			'payment' => (int) htmlspecialchars($_POST['payment'])
		];

		$cartItems .= '<section class="confirm-info"><section class="confirm-addr">
			<h3>Fakturační adresa</h3>
			<p class="confirm-name">' . htmlspecialchars($_POST['name'] . '&nbsp;' . $_POST['surname']) . '</p>
			<p class="confirm-name">' . $_POST['email'] . '</p>
			<p class="confirm-name">' . $_POST['phone'] . '</p>
			<p class="confirm-name">' . $_POST['street'] . ', ' . $_POST['zip'] . '&nbsp;' . $_POST['city'] . '</p>
			<p class="confirm-name">' . COUNTRIES[(int) $_POST['country']] . '</p>
		</section>';

		if (!empty($_POST['alt-street'])) {
			$cartItems .= '<section class="confirm-alt-addr">
				<h3>Doručit na adresu:</h3>
				<p class="confirm-name">' . $_POST['alt-street'] . ', ' . $_POST['alt-zip'] . '&nbsp;' . $_POST['alt-city'] . '</p>
				<p class="confirm-name">' . COUNTRIES[(int) $_POST['alt-country']] . '</p>
			</section>';

		} else {
			$cartItems .= '<section class="confirm-alt-addr"></section>';
		}

		$cartItems .= '<section class="confirm-sum">
			<h3>Souhrn cen</h3>
			<p class="confirm-sum-count">Počet položek: ' . $count . '</p>
			<p class="confirm-sum-novat">Bez DPH celkem: ' . number_format(nonVAT($sum), 2, ',', '') . ' Kč</p>
			<p class="confirm-sum-nvat">DPH celkem: ' . number_format(VAT($sum), 2, ',', '') . ' Kč</p>
			<p class="b">Cena celkem: ' . number_format($sum, 2, ',', '') . ' Kč</p>
		</section></section>';

		$cartItems .= '</section><section class="confirm-info">
			<div class="button-align">
			<form action="dokonceni/index.php" method="POST">
			<input type="submit" id="cart-proceed" value="Pokračovat k objednávce">
			</form>
			</div>
		</section>';
	} else {
		header('Location: ..');
	}
} else {
	header('Location: ..');
}

?>
