<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.products.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="../..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - produkty</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/user.css">
	<link rel="stylesheet" href="css/modal.css">
	<script src="js/lib.js"></script>
	<script src="js/modal.js" defer="defer"></script>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelector('#addProd').addEventListener('click', function(e) {
				e.preventDefault();
				let m = document.querySelector('.modal');
				m.style.display = "block";
			});
		});

	</script>
	<style>
		@charset "UTF-8";

		.content a {
			width: 100%;
			margin: 10px 0;
		}

		.order-prices {
			min-width: 240px;
		}

		.product-image {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100%;
			width: 100px;
		}

		.product-image img {
			max-height: 100px;
		}

		.order {
			max-height: 100px;
		}

		.order-disc {
			width: 25%;
		}

		.order > h3 {
			min-width: 10%;
		}

		.page-title {
			width: 80%;
		}

		.add-btn-cont {
			width: 20%;
		}

		.special {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: space-between;
			width: 100%;
			padding-right: 3.5%;
			box-sizing: border-box;
		}



	</style>
</head>
<body>
	<script>0</script>
	<?php
		echo HEADER;
		echo MAIN_OPEN;
		echo SIDEBAR_LEFT;
	?>
	<main class="content">
		<div class="special">
			<h1 class="page-title"><?php echo backButton('uzivatel/index.php'); ?>Produkty</h1>
			<div class="add-bt-cont"><button id="addProd">Přidat produkt</button></div>
		</div>
		<?php echo $content; ?>
	</main>
	<div class="modal" id="modalbox">
		<form action="administrace/produkt/index.php" method="POST" enctype="multipart/form-data">
			<div class="modal-header">
				<h3 id="passchange-h">Změna údajů</h3>
			</div>
			<div class="modal-content">
				<input type="hidden" name="action" value="addProduct">
			<div class="labeled-input">
				<label for="name">Název: </label>
				<input type="text" name="name" class="input input-text" required="required">
			</div>
			<div class="labeled-input">
				<label for="desc">Popis: </label>
				<input type="text" name="desc" class="input input-text" required="required">
			</div>
			<div class="labeled-input">
				<label for="picture">Obrázek: </label>
				<input type="file" name="picture" required="required">
			</div>
			<div class="labeled-input">
				<label for="quantity">Kvantita: </label>
				<input type="number" name="quantity" class="input input-number" required="required" value="1">
			</div>
			<div class="labeled-input">
				<label for="unit">Jednotka: </label>
				<input type="text" name="unit" class="input input-text" required="required" value="ks">
			</div>
			<div class="labeled-input">
				<label for="price">Cena: </label>
				<input type="number" name="price" min="0" max="1.7976931348623E+308" step="0.01" class="input input-text" required="required">
			</div>
			<div class="labeled-input">
				<label for="discountPrice">Zlevněná cena: </label>
				<input type="number" name="discountPrice" min="0" max="1.7976931348623E+308" step="0.01" class="input input-text">
			</div>
			</div>
			<div class="modal-footer">
				<input type="submit" value="Přidat produkt">
			</div>
		</form>
	</div>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>