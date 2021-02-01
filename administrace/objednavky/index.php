<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.orders.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="../..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - objednávky</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/user.css">
	<script src="js/lib.js"></script>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.fullfill').forEach(function(f){
				f.addEventListener('click', function(e) {
					let id = e.target.getAttribute('data-id');
					let fin = e.target.getAttribute('data-finished');
					request('POST', 'administrace/objednavky/index.php', 'action=finish&id=' + id).then(function(r) {
						e.target.textContent = (fin == 1 ? 'Odeslat' : 'Vzít zpět');
						document.querySelector('p[data-id="' + id + '"]').textContent = 'Odeslána: ' + (fin == 1 ? 'Ne' : 'Ano');
						document.querySelector('button[data-id="' + id + '"]').setAttribute('data-finished', Math. abs(fin - 1));
					})
					.catch(function(r) {
						console.log(r);
					});
				});
			});

			document.querySelectorAll('.remOrder').forEach(function(f){
				f.addEventListener('submit', function(e) {
					if (!window.confirm('Opravdu si přejete smazat tuto objednávku?')) {
						e.preventDefault();
					}
				});
			});

			document.querySelectorAll('a.nolink').forEach(function(a) {
				a.addEventListener('click', function(e) {
					if (e.target.classList.contains('fullfill')) {
						e.preventDefault();
					}
				});
			});
		});

	</script>
	<style>
		@charset "UTF-8";

		.content a {
			width: 100%;
			margin: 10px 0;
		}

		.user-buttons {
			width: 180px;
			display: flex;
			justify-content: space-between;
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
		<h1 class="page-title"><?php echo backButton('uzivatel'); ?>Objednávky</h1>
		<?php echo $content; ?>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>