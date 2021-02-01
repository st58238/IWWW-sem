<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.users.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="../..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - uživatelé</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/user.css">
	<script src="js/lib.js"></script>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.remUser').forEach(function(i) {
				i.addEventListener('submit', function(e) {
					if (!window.confirm('Opravdu si přejete odebrat tohoto uživatele?')) {
						e.preventDefault();
					}
				});
			});
		});

	</script>
	<style>
		@charset "UTF-8";

		.user-box {
			width: 100%;
			margin: 10px 0;
			padding: 0 15px;
			box-sizing: border-box;
			background-color: rgba(225, 225, 225, 0.35);
			transition: 0.3s;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.user-box:hover {
			background-color: lightgrey;
			transition: 0.3s;
		}

		.user-box h3 {
			min-width: 280px;
		}

		.order-prices {
			min-width: 150px;
			display: flex;
			justify-content: space-between;
		}

		.order-user {
			width: 30%;
			text-align: center;
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
		<h1 class="page-title"><?php echo backButton('uzivatel'); ?>Uživatelé</h1>
		<?php echo $content; ?>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>