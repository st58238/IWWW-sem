<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/finish.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - potvrzení objednávky</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/cart.css">
	<script src="js/lib.js"></script>
</head>
<body>
	<script>0</script>
	<?php
		echo HEADER;
		echo MAIN_OPEN;
		echo SIDEBAR_LEFT;
	?>
	<main class="content">
		<?php echo $content; ?>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>