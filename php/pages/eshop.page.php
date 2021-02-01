<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$htmlFilters = '';
$items = '';

if (isset($_POST['action'])) {
	$core = Core::getInstance();

	if ($_POST['action'] == 'addTag') {
		$tag = $core->getControl()->getTagById((int) $_POST['tagId']);
		$_SESSION['tags'][$tag->getId()] = $tag;

		if (!isset($_POST['noreturn'])) {
			echo composeItems($_SESSION['tags']);
		}
	} else if ($_POST['action'] == 'removeTag') {
		$tag = $core->getControl()->getTagById((int) $_POST['tagId']);
		unset($_SESSION['tags'][$tag->getId()]);

		if (!isset($_POST['noreturn'])) {
			echo composeItems($_SESSION['tags']);
		}
	} else if ($_POST['action'] == 'clearTags') {
		unset($_SESSION['tags']);
		$_SESSION['tags'] = array();
		if (!isset($_POST['noreturn'])) {
			echo null;
		}
	}
} else {
	$core = Core::getInstance();

	$tags = $core->getControl()->getAllTags();
	$htmlFilters .= '<section class="filters"><ul class="tags">';
	foreach ($tags as $t) {
		if (in_array($t, $_SESSION['tags'])) {
			$htmlFilters .= '<li data-id="' . $t->getId() . '" data-selected="1">' . $t->getText() . '<span class="tag-bullet">&bull;</span></li>';
		} else {
			$htmlFilters .= '<li data-id="' . $t->getId() . '">' . $t->getText() . '<span class="tag-bullet">&bull;</span></li>';
		}
	}

	$items = composeItems($_SESSION['tags']);
}

$htmlFilters .= '</ul></section>';


function composeItems(array &$tags) {
	$core = Core::getInstance();
	$pr = $core->getControl()->getAllProducts($tags);

	$items = '<section class="items">';
	foreach ($pr as $p) {
		$items .= '
			<article class="product">
				<a class="product-link" href="produkt/index.php?id=' . $p->getId() . '">
					<h2 class="product-name">' . $p->getName() . '</h2>
					<div class="product-image-container">
						<img class="product-image" src="img/eshop/' . $p->getImg() . '" alt="'. $p->getImg() . '">
					</div>
				</a>
				<section class="product-stockinfo">
					<p class="product-stock">' . ($p->getStock() ? 'Skladem' : 'Není skladem') . '</p>
					<p class="product-price">' . $p->getFullPrice() . '</p>
				</section>
				<p class="product-desc">' . $p->getDesc() . '</p>
			</article>
		';
	}
	return ($items . '</section>');
}
?>
