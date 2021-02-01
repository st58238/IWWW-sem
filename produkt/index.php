<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/product.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - <?php echo PAGE_TITLE; ?></title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/item.css">
	<style>
		@charset "UTF-8";

		.tags {
			justify-content: flex-start;
			flex-shrink: 0;
			padding-left: 0;
		}

		.input {
			width: 100%;
			max-width: 80px;
			height: 100%;
			margin-right: 20px;
			box-sizing: border-box;
			font-size: 0.95em;
			text-align: center;
		}

		.form {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: flex-end;
		}

	</style>
	<script src="js/lib.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function(){
			let tagMarks = document.querySelectorAll('.tags li');
			tagMarks.forEach(function(t){
				t.addEventListener('click', function(e){
					let id = parseInt(e.target.dataset.id);
					request('POST', 'php/pages/eshop.page.php', 'action=clearTags&noreturn')
					.then(function(r) {
						request('POST', 'php/pages/eshop.page.php', 'action=addTag&tagId=' + id)
						.then(function(){
							location.href = 'eshop/';
						})
						.catch(console.log(r));
					})
					.catch(function(r) {
						console.log(r);
					});
				});
			});
		});
	</script>
</head>
<body>
	<script>0</script>
	<?php
		echo HEADER;
		echo MAIN_OPEN;
		echo SIDEBAR_LEFT;
	?>
	<main class="content">
		<!------------------------------------------------->
		<?php echo $item; ?>
		<!------------------------------------------------->
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>
