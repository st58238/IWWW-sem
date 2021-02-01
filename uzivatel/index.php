<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/user.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - uživatel</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/user.css">
	<link rel="stylesheet" href="css/modal.css">
	<script src="js/lib.js"></script>
	<script src="js/modal.js" defer="defer"></script>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelector('#passchange').addEventListener('click', function(e) {
				e.preventDefault();
				let m = document.querySelector('.modal');
				m.style.display = "block";
			});

			document.querySelector('.modal-footer>input[type="submit"]').addEventListener('click', function(e) {
				let old = document.querySelector('input[name="old"]');
				let ne = document.querySelector('input[name="new"]');
				let again = document.querySelector('#again');
				if (ne.value == again.value && (old.value.length > 0 && ne.value.length > 0 && again.value.length > 0)) {

				} else {
					e.preventDefault();
					alert('Nová hesla se neshodují.');
				}
			});

			document.querySelector('#deleteaccount').addEventListener('click', function(c) {
				c.preventDefault();
				if (window.confirm('Opravdu si přejete odstranit svůj účet? Tuto akci nelze zrušit.')) {
					document.querySelector('#delacc').submit();
				}
			});
		});

	</script>
	<style>
		@charset "UTF-8";

		.erase {
			margin-top: 100px;
		}

		#delacc {
			display: none;
		}

		.content {
			flex-direction: column;
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
		<h1 class="page-title"><?php echo backButton('./index.php'); ?>Uživatel</h1>
		<?php echo $content; ?>
	</main>
	<div class="modal" id="modalbox">
		<form action="uzivatel/index.php" method="POST">
			<div class="modal-header">
				<h3 id="passchange-h">Změna hesla</h3>
			</div>
			<div class="modal-content">
				<input type="hidden" name="action" value="passChange">
				<div class="labeled-input">
					<label for="old">Staré heslo:</label>
					<input type="password" name="old" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="new">Nové heslo:</label>
					<input type="password" name="new" class="input input-text">
				</div>
				<div class="labeled-input">
					<label>Nové heslo znovu:</label>
					<input id="again" type="password" class="input input-text">
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" value="Změnit heslo">
			</div>
		</form>
		<form action="uzivatel/index.php" id="delacc" method="POST">
			<input type="hidden" name="action" value="deleteAccount">
		</form>
	</div>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>