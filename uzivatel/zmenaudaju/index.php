<?php

require_once(__DIR__ . '/../../php/core.php');
require_once(__DIR__ . '/../../php/html.php');

require_once(__DIR__ . '/../../php/pages/user.changeinfo.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="../..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - změna údajů</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/user.css">
	<script src="js/lib.js"></script>
	<style>
		@charset "UTF-8";

		.erase {
			margin-top: 100px;
		}

		.input {
			padding: 5px;
		}

		form {
			width: 100%;
			display: flex;
			flex-direction: column;
		}

		form .input {
			width: 50%;
		}

		.labeled-input {
			margin-bottom: 20px;
		}

		.blank-fill {
			width: 95%;
			display: flex;
			justify-content: flex-end;
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
		<form action="uzivatel/zmenaudaju/index.php" method="POST">
			<h1 class="page-title"><?php echo backButton(); ?>Změna údajů</h1>
			<?php echo $content; ?>
			<div class="labeled-input">
				<label for="email">Email<span class="red">*</span>:</label>
				<input type="text" name="email" class="input input-text" required="required" value="<?php echo $emailOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="name">Jméno<span class="red">*</span>:</label>
				<input type="text" name="name" class="input input-text" required="required" value="<?php echo $nameOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="surname">Příjmení<span class="red">*</span>:</label>
				<input type="text" name="surname" class="input input-text" required="required" value="<?php echo $surnameOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="phone">Telefon:</label>
				<input type="text" name="phone" class="input input-text" value="<?php echo $phoneOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="street">Ulice:</label>
				<input type="text" name="street" class="input input-text" value="<?php echo $streetOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="city">Město:</label>
				<input type="text" name="city" class="input input-text" value="<?php echo $cityOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="zip">PSČ:</label>
				<input type="text" name="zip" class="input input-text" value="<?php echo $zipOld; ?>">
			</div>
			<div class="labeled-input">
				<label for="country">Země:</label>
				<?php echo $select; ?>
			</div>
			<div class="blank-fill">
				<input type="submit" value="Změnit údaje">
			</div>
		</form>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>