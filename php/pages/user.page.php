<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null) {
		$core = Core::getInstance();
		$control = $core->getControl();

		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'passChange') {
				if (password_verify($_POST['old'], $control->getUserPassword($_SESSION['user']))) {
					$u = $control->updatePassword($_SESSION['user'], $_POST['new'], false);
					if ($u != null) {
						$_SESSION['user'] = $u;
					}
				}
			} else if ($_POST['action'] == 'deleteAccount') {
				if ($control->deleteUser($_SESSION['user'])) {
					$_SESSION['user'] = null;
					header('Location: ../login');
					exit(0);
				}
			}
		}

		$user = &$_SESSION['user'];

		$content = '<div class="correction"><aside class="user-nav">';
		if ($_SESSION['user']->getRole() >= 750) {
			$content .= '<a href="administrace/objednavky" class="nolink"><p>Objednávky</p></a>';
		}

		if ($_SESSION['user']->getRole() >= 500) {
			$content .= '<a href="administrace/produkty" class="nolink"><p>Správa produktů</p></a>';
			$content .= '<a href="administrace/tagy" class="nolink"><p>Správa tagů</p></a>';
			$content .= '<a href="administrace/export" class="nolink"><p>Import/Export dat</p></a>';
		}

		if ($_SESSION['user']->getRole() >= 1000) {
			$content .= '<a href="administrace/uzivatele" class="nolink"><p>Správa uživatelů</p></a>';
		}

		$content .= '<a href="uzivatel/mojeobjednavky" class="nolink"><p>Moje objednávky</p></a>
			<a href="uzivatel/zmenaudaju" class="nolink" id="infochange"><p>Změna údajů</p></a>
			<a href="uzivatel/zmenahesla" class="nolink" id="passchange"><p>Změna hesla</p></a>
			<a href="uzivatel/zrusitucet" class="nolink erase" id="deleteaccount"><p class="red">Zrušit účet</p></a></aside>';

		$content .= '<section class="user-info">
			<h2 class="user-fullname">' . $user->getName() . ' ' . $user->getSurname() . '</h2>
			<h3 class="user-email">' . $user->getEmail() . '</h3>';

		if ($user->getPhone() != null) {
			$content .= '<p class="user-phone">Telefon: ' . $user->getPhone() . '</p>';
		}
		if ($user->getStreet() != null) {
			$content .= '<p class="user-street">Ulice: ' . $user->getStreet() . '</p>';
		}
		if ($user->getCity() != null) {
			$content .= '<p class="user-city">Město: ' . $user->getCity() . '</p>';
		}
		if ($user->getZip() != null && $user->getZip() != 0) {
			$content .= '<p class="user-zip">PŠČ: ' . $user->getZip() . '</p>';
		}
		if ($user->getCountry() != null && $user->getStreet() != null && $user->getCity() != null && $user->getZip() != 0) {
			$content .= '<p class="user-country">Země: ' . $user->getCountry() . '</p>';
		}
		$content .= '<button class="logout-button" onclick="location.href = &quot;login/index.php?action=logout&quot;">Odhlásit se</button>';

		$content .= '</section></div>';
	} else {
		header('Location: login');
		exit(1);
	}
} else {
	header('Location: login');
	exit(1);
}

?>
