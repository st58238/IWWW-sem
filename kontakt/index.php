<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna</title>
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/contact.css">
	<script src="https://api.mapy.cz/loader.js"></script>
	<script type="text/javascript">
		Loader.load();

		document.addEventListener('DOMContentLoaded', function() {
			var stred = SMap.Coords.fromWGS84( 15.7736356, 49.9781306);
			var mapa = new SMap(JAK.gel("mapa"), stred, 15);
			mapa.addDefaultLayer(SMap.DEF_BASE).enable();
			mapa.addDefaultControls();	      	      
		});
		
	</script>
	<style>
		@charset "UTF-8";

		#mapa {
			width: 95%;
			height: 400px;
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
		<section class="contacts">
			<article class="contact">
				<div class="cont">
					<img class="contact-image" src="img/user.svg" alt="user.svg">
				</div>
				<h2 class="cont-role">Vlastník</h2>
				<h3 class="cont-name">Šimon&nbsp;Čech</h3>
				<p class="cont-compress">simon.c@vinarna.cz</p>
				<p class="cont-compress">+420&nbsp;456&nbsp;879&nbsp;123</p>
				<p class="cont-compress">Dotazy ohledně firemních spoluprací</p>
			</article>
			<article class="contact">
				<div class="cont">
					<img class="contact-image" src="img/user.svg" alt="user.svg">
				</div>
				<h2 class="cont-role">Asistentka</h2>
				<h3 class="cont-name">Laura&nbsp;Světlá</h3>
				<p class="cont-compress">vinarna@vinarna.cz</p>
				<p class="cont-compress">+420&nbsp;456&nbsp;879&nbsp;124</p>
				<p class="cont-compress">Dotazy ohledně produktů a nabídek</p>
			</article>
			<article class="contact">
				<div class="cont">
					<img class="contact-image" src="img/user.svg" alt="user.svg">
				</div>
				<h2 class="cont-role">Administrátor</h2>
				<h3 class="cont-name">Lukáš Janáček</h3>
				<p class="cont-compress">admin@vinarna.cz</p>
				<p class="cont-compress">+420&nbsp;456&nbsp;879&nbsp;122</p>
				<p class="cont-compress">Dotazy k funkčnosti a práci webu</p>
			</article>
			<article class="contact">
				<h2 class="cont-role">Prodejna</h2>
				<h3 class="cont-name">Hlavní 78</h3>
				<p class="cont-compress">538&nbsp;22 Medlešice</p>
				<p class="cont-compress">+420&nbsp;456&nbsp;879&nbsp;120</p>
				<p class="cont-compress">Dotazy k funkčnosti a práci webu</p>
			</article>
		</section>
		<h3 class="cont-find">Kde nás najdete</h3>
		<div id="mapa"></div>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>