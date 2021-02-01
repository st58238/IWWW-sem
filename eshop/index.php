<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/eshop.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - Eshop</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/eshop.css">
	<script src="js/lib.js"></script>
	<script src="js/eshop.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function(){
			let tagMarks = document.querySelectorAll('.tags li');
			tagMarks.forEach(function(t){
				t.addEventListener('click', function(e){
					let node = e.target;
					if (node.parentNode.nodeName == 'LI') {
						node = node.parentNode;
					}
					
					let id = node.getAttribute('data-id');
					if (node.getAttribute('data-selected') == 1) {
						request('POST', 'php/pages/eshop.page.php', 'action=removeTag&tagId=' + id).then(function(r) {
							refreshItems(r);
						}).catch(function(r) {
							console.log(r);
						});
						node.removeAttribute('data-selected');
					} else {
						request('POST', 'php/pages/eshop.page.php', 'action=addTag&tagId=' + id).then(function(r) {
							refreshItems(r);
						}).catch(function(r) {
							console.log(r);
						});
						node.setAttribute('data-selected', 1);
					}
				});
			});
		});
	</script>
	<style>
		#eshop-items {
			width: 100%;
		}

		.items {
			justify-content: center;
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
		<?php echo $htmlFilters; ?>
		<hr />
		<div id="eshop-items">
			<?php echo $items; ?>
		</div>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>