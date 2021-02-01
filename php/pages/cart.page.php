<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

if (isset($_POST['action']) && isset($_POST['id'])) {
	$id = (int) htmlspecialchars($_POST['id']);
	$count = -1;

	if (isset($_POST['count'])) {
		$count = (int) htmlspecialchars($_POST['count']);
	}
	
	if ($_POST['action'] == 'removeItem' || $count <= 0) {
		unset($_SESSION['cart'][$id]);
	} else if ($_POST['action'] == 'addItem') {
		$_SESSION['cart'][$id] = ['id' => $id, 'count' => $count];
	}

	if (isset($_POST['noreturn'])) {
		return;
	}
}

$cartItems = '<h3>Košík je prázdný.</h3>';
$sum = 0;
$count = 0;

if (!empty($_SESSION['cart'])) {
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
				<section class="cart-tags">
					<ul class="tags">';
		foreach ($core->getControl()->getProductTags($p->getId(), 3) as $tag) {
			$cartItems .= '<li data-id="' . $tag[0] . '">' . $tag[1] . '<span class="tag-bullet">&bull;</span></li>';
		}
		$cartItems .= '</ul>
				</section>
				<p class="cart-stock">' . ($p->getStock() ? '<span class="green">Skladem</span>' : '<span class="red">Není skladem</span>') . '</p>
				<p class="cart-price">' . $p->getFullPrice() . '</p>
				<input type="number" class="input input-number" name="count-' . $p->getId() . '" value="' . $pair['count'] . '" min="0" step="1" data-id="' . $p->getId() . '" data-price="' . $p->getCorrectPrice() . '">
			</article>
			<hr />
		';
	}

	$cartItems .= '<section class="cart-sum">
		<p class="cart-sum-count">Počet položek: ' . $count . '</p>
		<p class="cart-sum-price">Cena celkem: ' . number_format($sum, 2, ',', '') . ' Kč</p>
		<button id="cart-proceed">Pokračovat k objednávce</button>
	</section>';

	$cartItems .= '</section>';	
}

?>
