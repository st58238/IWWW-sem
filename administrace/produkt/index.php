<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.product.page.php');

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
		const pid = <?php echo (int) $pid; ?>;

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelector('#infochange').addEventListener('click', function(e) {
				e.preventDefault();
				let m = document.querySelector('#modalbox');
				m.style.display = "block";
			});

			document.querySelector('#tagchange').addEventListener('click', function(e) {
				e.preventDefault();
				let m = document.querySelector('#modalbox2');
				m.style.display = "block";
			});

			document.querySelector('#deleteProduct').addEventListener('click', function(c) {
				c.preventDefault();
				if (window.confirm('Opravdu si přejete odstranit tento produkt? Tuto akci nelze zrušit.')) {
					document.querySelector('#delProd').submit();
				}
			});

			let tagMarks = document.querySelectorAll('.tags li');
			tagMarks.forEach(function(t){
				if (t.getAttribute('data-selected') == '1') {
					selectedTags.set(parseInt(t.getAttribute('data-id')), parseInt(t.getAttribute('data-id')));
				}

				t.addEventListener('click', function(e){
					let node = e.target;
					if (node.parentNode.nodeName == 'LI') {
						node = node.parentNode;
					}

					let id = parseInt(node.getAttribute('data-id'));
					if (node.getAttribute('data-selected') == 1) {
						request('POST', 'php/pages/admin.product.page.php', 'action=removeTag&tagId=' + id + '&id=' + pid).then(function(r) {
							refreshTags(r);
						}).catch(function(r) {
							console.log(r);
						});
						node.removeAttribute('data-selected');
						selectedTags.delete(id);
					} else {
						request('POST', 'php/pages/admin.product.page.php', 'action=addTag&tagId=' + id + '&id=' + pid).then(function(r) {
							refreshTags(r);
						}).catch(function(r) {
							console.log(r);
						});
						node.setAttribute('data-selected', 1);
						selectedTags.set(id, id);
					}
				});
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

		#modalbox2 > div{
			width: 50%;
		}

		#modalbox2 .modal-footer button {
			margin-right: 2%;
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
		<h1 class="page-title"><?php echo backButton('administrace/produkty/index.php'); ?>Produkt</h1>
		<div class="correction">
			<aside class="user-nav">
				<a href="administrace/produkt/#" class="nolink" id="infochange"><p>Změna údajů</p></a>
				<a href="administrace/produkt/#" class="nolink" id="tagchange"><p>Upravit tagy</p></a>
				<a href="administrace/produkt/#" class="nolink erase" id="deleteProduct"><p class="red">Odebrat produkt</p></a>
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