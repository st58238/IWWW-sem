<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$core = null;

if (isset($_GET['action'])) {
	if ($_GET['action'] == 'logout') {
		$core = Core::getInstance();
		$core->getControl()->logout();
		header('Location: .');
	}
}

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null) {
		header('Location: ../uzivatel');
		exit(0);
	}
}

if (isset($_POST)) {
	if (isset($_POST['action'])) {
		$core = Core::getInstance();
		$control = $core->getControl();
		if ($_POST['action'] == 'registration') {
			$mail = htmlspecialchars($_POST['email']);
			$pass = htmlspecialchars($_POST['password']);
			$name = htmlspecialchars($_POST['name']);
			$surname = htmlspecialchars($_POST['surname']);
			$phone = empty($_POST['phone']) ? null : htmlspecialchars($_POST['phone']);
			$street = empty($_POST['street']) ? null : htmlspecialchars($_POST['street']);
			$city = empty($_POST['city']) ? null : htmlspecialchars($_POST['city']);
			$zip = empty($_POST['zip']) ? null : (int) htmlspecialchars($_POST['zip']);
			$country = ($street == null || $city == null || $zip == null) ? null : (int) htmlspecialchars($_POST['country']);
			$pass = $_POST['password'];

			if (!preg_match(EMAIL_REGEXP, $mail)) {
				header('Location: index.php?error=email');
				exit(1);
			}

			$u = new User(null, $mail, $name, $surname, $phone, $street, $city, $zip, $country, 0);

			$user = $control->insertUser($u, $pass, false);


			if ($user !== null) {
				$_SESSION['user'] = $user;
				header('Location: ../uzivatel');
				exit(0);
			} else {
				$_SESSION['user'] = null;
				header('Location: index.php?error=general');
				exit(1);
			}

		} else if ($_POST['action'] == 'login') {
			$mail = htmlspecialchars($_POST['email']);
			$pass = htmlspecialchars($_POST['password']);

			$user = $control->authUser($mail, $pass);

			if ($user !== null) {
				$_SESSION['user'] = $user;
				header('Location: ../uzivatel');
				exit(0);
			} else {
				$_SESSION['user'] = null;
				//header('Location: .');
				//exit(1);
			}
		}
	}
}

?>
