<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';
$pid = -1;

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 500) {
		$core = Core::getInstance();
		$control = $core->getControl();


		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'infoChange' || $_POST['action'] == 'addProduct') {
				$id = (int) htmlspecialchars($_POST['id']);
				$name = htmlspecialchars($_POST['name']);
				$desc = htmlspecialchars($_POST['desc']);
				$picture = $_FILES['picture'];
				$quantity = (int) htmlspecialchars($_POST['quantity']);
				$unit = htmlspecialchars($_POST['unit']);
				$price = (float) htmlspecialchars($_POST['price']);
				$discountPrice = !empty($_POST['discountPrice']) ? (float) htmlspecialchars($_POST['discountPrice']) : null;

				$p = null;

				if ($_POST['action'] == 'infoChange') {
					$p = $control->getProductById($id);
					$n = new Product($p->getId(), $name, $desc, $p->getPicture(), $quantity, $unit, true, $price, $discountPrice, true);

					$control->updateProduct($p, $n);
				} else if ($_POST['action'] == 'addProduct') {
					$p = new Product(null, $name, $desc, strtolower(preg_replace('/\s*/', '', preg_replace('/[^a-zA-Z0-9]/', '', $name) . '.' . pathinfo($picture['name'])['extension'])), $quantity, $unit, true, $price, $discountPrice, true);

					$id = $control->insertRecord($p);
					header('Location: ../produkt/index.php?id=' . $id);
				}

				if (!empty($_FILES['picture']) && is_uploaded_file($picture['tmp_name'])) {
					rename($_FILES['picture']['tmp_name'], __DIR__ . '/../../img/eshop/' . $p->getPicture());
				}
				
			} else if ($_POST['action'] == 'deleteProduct' && isset($_POST['id'])) {
				$image = $control->getProductById((int) htmlspecialchars($_POST['id']))->getPicture();
				
				$control->removeProduct((int) htmlspecialchars($_POST['id']));
				unlink(__DIR__ . '/../../img/eshop/' . $image);

				header('Location: ../produkty');
				exit(0);
			} else if ($_POST['action'] == 'addTag' && isset($_POST['tagId']) && isset($_POST['id'])) {
				$control->addProductTag((int) htmlspecialchars($_POST['id']), (int) htmlspecialchars($_POST['tagId']));
				if (!isset($_POST['noreturn'])) {
					echo buildPresentTags($_POST['id']);
				}
				exit(0);
			} else if ($_POST['action'] == 'removeTag' && isset($_POST['tagId']) && isset($_POST['id'])) {
				$control->removeProductTag((int) htmlspecialchars($_POST['id']), (int) htmlspecialchars($_POST['tagId']));
				if (!isset($_POST['noreturn'])) {
					echo buildPresentTags($_POST['id']);
				}
				exit(0);
			}
		}

		$sql = 'SELECT name, picture, quantity, unit, stock, price, discount_price, display, id_product FROM products ';

		$p = $control->getProductById((int) htmlspecialchars($_GET['id']));

		$pid = $p->getId();

		if (empty($p) || $p === null) {
			$content .= '<h2 class="red">Neplatná položka</h2>';
		} else {
			$content .= '<section class="user-info">
			<h2 class="user-fullname">' . $p->getName() . '</h2>
			<div id="pTags">' . buildPresentTags($p->getId()) . '</div>
			<div>
			<img class="product-image" src="img/eshop/' . $p->getPicture() . '" alt="' . $p->getPicture() . '">
			</div>
			<p class="order-user">' . $p->getDesc() . '</p>
			<p class="order-user">' . number_format($p->getPrice(), 2, ',', '') . ' Kč/' . $p->getQuantity() . ' ' . $p->getUnit() . '</p>
			<p class="order-user">Zlevněno' . ($p->getDiscountPrice() == null ? ': Ne' : (' na ' . number_format($p->getDiscountPrice(), 2, ',', '') . ' Kč/' . $p->getQuantity() . ' ' . $p->getUnit())) . '</p>
			<p class="order-user">V prodeji: ' . ($p->getDisplay() == 1 ? 'Ano' : 'Ne' ) . '</p></section>';



			$content .= '<div class="modal" id="modalbox">
				<form action="administrace/produkt/index.php?id=' . $p->getId() . '" method="POST" enctype="multipart/form-data">
				<div class="modal-header">
				<h3 id="passchange-h">Změna údajů</h3>
				</div>
				<div class="modal-content">
				<input type="hidden" name="action" value="infoChange">
				<input type="hidden" name="id" value="' . $p->getId() . '">
				<div class="labeled-input"><label for="name">Název: </label>
				<input type="text" name="name" class="input input-text" value="' . $p->getName() . '"></div>
				<div class="labeled-input"><label for="desc">Popis: </label>
				<input type="text" name="desc" class="input input-text" value="' . $p->getDesc() . '"></div>
				<div class="labeled-input"><label for="picture">Obrázek: </label>
				<input type="file" name="picture"></div>
				<div class="labeled-input"><label for="quantity">Kvantita: </label>
				<input type="number" name="quantity" class="input input-number" value="' . $p->getQuantity() . '"></div>
				<div class="labeled-input"><label for="unit">Jednotka: </label>
				<input type="text" name="unit" class="input input-text" value="' . $p->getUnit() . '"></div>
				<div class="labeled-input"><label for="price">Cena: </label>
				<input type="number" name="price" min="0" max="' . PHP_FLOAT_MAX . '" step="0.01" class="input input-text" value="' . $p->getPrice() . '"></div>
				<div class="labeled-input"><label for="discountPrice">Zlevněná cena: </label>
				<input type="number" name="discountPrice" class="input input-text" value="' . $p->getDiscountPrice() . '"></div>
				</div>
				<div class="modal-footer">
				<input type="submit" value="Změnit údaje">
				</div>
				</form>
				</div>
				<form action="administrace/produkt/index.php" id="delProd" method="POST">
				<input type="hidden" name="action" value="deleteProduct">
				<input type="hidden" name="id" value="' . $p->getId() . '">
			</form>';

			$content .= '<div class="modal" id="modalbox2">
				<div class="modal-header">
				<h3 id="passchange-h">Změna tagů</h3>
				</div>
				<div class="modal-content">';
			$content .=  buildTags($p->getId());
			$content .= '</div>
				<div class="modal-footer">
				<button class=".modal" id="modalboxCloseTags">Zavřít</button>
			</div>';
		}

	} else {
		header('Location: ../login');
		exit(1);
	}
} else {
	header('Location: ../login');
	exit(1);
}

function buildTags(int $id): string {
	$control = Core::getInstance()->getControl();
	$st = $control->getAllAndSelectedTags($id);
	$content = '<section class="filters"><ul class="tags">';
	foreach ($st[0] as $t) {
		if (array_key_exists($t->getId(), $st[1])) {
			$content .= '<li data-id="' . $t->getId() . '" data-selected="1">' . $t->getText() . '<span class="tag-bullet">&bull;</span></li>';
		} else {
			$content .= '<li data-id="' . $t->getId() . '">' . $t->getText() . '<span class="tag-bullet">&bull;</span></li>';;
		}
	}
	
	return $content . '</ul></section>';
}

function buildPresentTags(int $id): string {
	$control = Core::getInstance()->getControl();
	$content = '<section class="filters"><ul class="tags">';

	foreach ($control->getProductTags($id) as $t) {
		$content .= '<li data-id="' . $t[0] . '">' . $t[1] . '<span class="tag-bullet">&bull;</span></li>';;
	}

	return $content . '</ul></section>'; 
}

?>
