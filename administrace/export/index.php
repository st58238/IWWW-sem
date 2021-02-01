<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/admin.export.page.php');

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

		});

	</script>
	<style>
		@charset "UTF-8";

		.content a {
			width: 100%;
		}

		form {
			width: 100%;
			margin: 0;
			padding-left: 10%;
			background-color: rgba(225, 225, 225, 0.15);
			transition: 0.3s;
			display: flex;
			justify-content: flex-start;
			flex-direction: column;
		}

		form *:not(p) {
			margin-left: -10%;
		}

		form:hover, form *:hover {
			background-color: lightgrey;
			transition: 0.3s;
		}

		input {
			text-align: center;
		}

		input[type="checkbox"] {
			margin: 0;
			padding-left: 20%;
		}

		.labeled-input {
			width: 100%;
			flex-direction: row;
		}

		.labeled-input > label {
			font-size: 14px;
			width: 40%;
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
		<h1 class="page-title"><?php echo backButton('uzivatel'); ?>Import/Export dat</h1>
		<?php echo $content; ?>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>