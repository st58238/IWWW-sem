<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.tags.page.php');

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
	<script src="js/admin.js"></script>
	<script src="js/modal.js" defer="defer"></script>
	<script>
		'use strict';

		let selectedTags = new Map();
		let id = -1;

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelector('#addTag').addEventListener('click', function(e) {
				e.preventDefault();
				document.querySelector('#modalbox').style.display = "block";
				document.querySelector('.modal-header>h3').textContent = 'Přidat tag';
				document.querySelector('.modal-content>input[name="action"]').value = 'addTag';
				document.querySelector('.hCont').style.display = 'none';
				document.querySelector('input[name="id"]').value = '';
				document.querySelector('input[name="text"]').value = '';
				document.querySelector('input[name="priority"]').value = '';
			});

			document.querySelectorAll('.tagchange').forEach(function(a) {
				a.addEventListener('click', function(e) {
					let node = e.target;
					if (node.parentNode.nodeName == 'LI') {
						node = node.parentNode;
					}

					document.querySelector('.modal-content>input[name="action"]').value = 'editTag';
					document.querySelector('.modal-header>h3').textContent = 'Upravit tag';
					document.querySelector('#modalbox').style.display = "block";
					document.querySelector('.hCont').style.display = 'flex';
					document.querySelector('input[name="id"]').value = parseInt(node.getAttribute('data-id'));
					document.querySelector('#remId').value = parseInt(node.getAttribute('data-id'));
					document.querySelector('#hidId').value = parseInt(node.getAttribute('data-id'));
					document.querySelector('input[name="text"]').value = node.getAttribute('data-name');
					document.querySelector('input[name="priority"]').value = parseInt(node.getAttribute('data-priority'));
				});
			});

			document.querySelector('#removeTagButton').addEventListener('click', function(c) {
				c.preventDefault();
				if (window.confirm('Opravdu si přejete odstranit tento tag? Tuto akci nelze zrušit.')) {
					document.querySelector('#delTag').submit();
				}
			});

		});

	</script>
	<style>
		@charset "UTF-8";

		.erase {
			margin-top: 100px;
		}

		.content {
			display: flex;
			flex-direction: column;
			flex-wrap: wrap;
			align-items: flex-start;
		}

		.modal-footer {
			flex-direction: row-reverse;
			justify-content: space-between;
		}

		#removeTagButton, #hideTagButton {
			margin-left: 15px;
			margin-right: 15px;
		}

		#delTag, #hTag {
			width: auto;
			margin: 0;
		}

		.hcont {
			display: flex;
			flex-direction: row-reverse;
			flex-wrap: nowrap;
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
		<h1 class="page-title"><?php echo backButton('uzivatel/index.php'); ?>Tagy</h1>
		<div class="correction">
			<aside class="user-nav">
				<a href="administrace/tagy/#" class="nolink" id="addTag"><p>Přidat tag</p></a>
			</aside>
			<?php echo $content; ?>
		</div>
	</div>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>