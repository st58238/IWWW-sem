<?php

require_once(__DIR__ . '/php/core.php');
require_once(__DIR__ . '/php/html.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href=".">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna</title>
	<link rel="stylesheet" href="./css/main.css">
	<style>
		@charset "UTF-8";

		.content {
			display: block;
			padding: 0 25px;
		}

		img {
			max-width: 30%;
		}

		@media only screen and (max-width: var(--response)) {
			img {
				width: 100%;
				max-width: none;
				padding: 15px 0 25px 0;
			}
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
		<h1>Vinárna</h1>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris metus. Donec ipsum massa, ullamcorper in, auctor et, scelerisque sed, est. Integer lacinia. Cras elementum. Duis sapien nunc, commodo et, interdum suscipit, sollicitudin et, dolor. Duis condimentum augue id magna semper rutrum. Fusce consectetuer risus a nunc. Nulla quis diam. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Integer lacinia. Fusce tellus. Nullam eget nisl. Praesent dapibus. Integer tempor. Mauris elementum mauris vitae tortor. Morbi leo mi, nonummy eget tristique non, rhoncus non leo.</p>

		<img src="img/logo.jpg" alt="logo.jpg" style="float: right; padding-left: 25px;">

		<p>Et harum quidem rerum facilis est et expedita distinctio. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit. Nam sed tellus id magna elementum tincidunt. Etiam ligula pede, sagittis quis, interdum ultricies, scelerisque eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam erat volutpat. Sed convallis magna eu sem. Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. Morbi scelerisque luctus velit. Praesent dapibus. Integer in sapien. Nunc tincidunt ante vitae massa.</p>
		
		<img src="img/wine-bg.jpg" alt="wine-bg.jpg" style="float: left; padding-right: 25px;">

		<p>Maecenas ipsum velit, consectetuer eu lobortis ut, dictum at dui. Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Aliquam erat volutpat. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Mauris tincidunt sem sed arcu. Sed ac dolor sit amet purus malesuada congue. Fusce wisi. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien. Etiam bibendum elit eget erat.</p>

		<p>Aenean fermentum risus id tortor. Etiam posuere lacus quis dolor. Aliquam ornare wisi eu metus. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Etiam neque. Aenean fermentum risus id tortor. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Nam quis nulla. Aenean fermentum risus id tortor. Fusce aliquam vestibulum ipsum.</p>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>