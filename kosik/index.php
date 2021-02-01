<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/cart.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - eshop</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/cart.css">
	<script src="js/lib.js"></script>
	<script src="js/cart.js"></script>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.input').forEach(function(i) {
				i.addEventListener('change', function(c) {
					let id = c.target.getAttribute('data-id');
					let count = c.target.value;
					request('POST', 'php/pages/cart.page.php', 'action=addItem&id=' + id + '&count=' + count + '&noreturn')
					.then(function(t) {
						console.log(t);
					})
					.catch(function(c) {
						console.log(c);
					});
					updatePrice();
				});
			});

			document.querySelector('#cart-proceed').addEventListener('click', function(e) {
				let inputs = document.querySelectorAll('.input');
				let check = inputs.length;
				let confirm = 0;

				inputs.forEach(function(i) {
					i.dispatchEvent(new Event('change'));
				});

				location.href = 'objednavka/index.php';
			});
		});

	</script>
	<style>
		@charset "UTF-8";

		.content {
			align-items: center;
		}

		.cart-items .cart-stock, .cart-items .cart-price, .input {
			font-size: 20px;
		}

		.input {
			width: 100px;
			text-align: center;
		}

		hr {
			width: 100%;
		}

		.tags {
			padding-left: 0;
		}

		button {
			font-size: 20px;
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
		<?php echo $cartItems; ?>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>