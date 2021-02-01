<?php

require_once(__DIR__ . '/../core.php');

sessionStart();

$item = '';

if (isset($_GET['id'])) {
	if (!empty($_GET['id'])) {
		$core = Core::getInstance();

		$i = $core->getControl()->getProductById((int) htmlspecialchars($_GET['id']));
		if ($i === null) {
			define('PAGE_TITLE', 'Chyba');
			$item = '<h2 class="error">Produkt s ID ' . htmlspecialchars($_GET['id']) . ', neexistuje.</h2>
		<p class="error">Pokud se tato chyba vyskytuje opakovaně odešlete prosím dotaz majiteli stránky.</p>';
			return;
		}

		define('PAGE_TITLE', $i->getName());

		$item .= '<section class="items">
				<article class="item">
					<div class="item-image-container">
						<img class="item-image" src="img/eshop/' . $i->getImg() . '" alt="' . $i->getImg() . '">
					</div>
					<div class="item-info">
						<h1 class="item-name">' . $i->getName() . '</h1>
						' . composeTags($core->getControl()->getProductTags($i->getId())) . '
						<section class="item-stockinfo">
							<p class="item-stock">' . ($i->getStock() ? 'Skladem' : 'Není skladem') . '</p>
							<p class="item-price">' . $i->getFullPrice() . '</p>
							<form action="kosik/index.php" method="post" accept-charset="utf-8" class="form">
								<input type="hidden" name="action" value="addItem">
								<input type="hidden" name="id" value="' . $i->getId() . '">
								<input type="number" name="count" value="1" min="0" step="1" class="input input-number">
								<button id="item-buy" type="submit">Koupit</button>
							</form>
						</section>
						<p class="item-desc">' . $i->getDesc() . '</p>
					</div>
				</article>
			</section>';
	} else {
		define('PAGE_TITLE', 'Chyba');
		$item = '<h2 class="error">Nedorazil parametr ID, nemodifikujte hlavičku.</h2>
		<p class="error">Pokud se tato chyba vyskytuje opakovaně odešlete prosím dotaz majiteli stránky.</p>';
	}
} else {
	define('PAGE_TITLE', 'Chyba');
	$item = '<h2 class="error">Nedorazil parametr ID, nemodifikujte hlavičku.</h2><p class="error">Pokud se tato chyba vyskytuje opakovaně odešlete prosím dotaz majiteli stránky.</p>';
}

?>