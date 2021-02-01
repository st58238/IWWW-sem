<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 1000) {
		$core = Core::getInstance();
		$control = $core->getControl();

		if (isset($_POST['action']) && isset($_POST['id'])) {
			if ($_POST['action'] == 'deleteUser') {
				$control->changeUserStatus((int) htmlspecialchars($_POST['id']));
			} else if ($_POST['action'] == 'removeUser') {
				$control->removeUser((int) htmlspecialchars($_POST['id']));
			}
			header('Location: .');
		}

		$es = array('', 's=10&e=10');
		$sql = 'SELECT email, name, surname, phone, id_user, active FROM users ORDER BY id_user DESC ';
		if (isset($_GET['s']) && isset($_GET['e'])) {
			$sql .= 'LIMIT ' . max((int) htmlspecialchars($_GET['s']), 0) . ', '. max((int) htmlspecialchars($_GET['e']), 1);
			$es[0] = 's=' . (max((int) htmlspecialchars($_GET['s']) - 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
			$es[1] = 's=' . (max((int) htmlspecialchars($_GET['s']) + 10, 0)) . '&e=' . ((int) htmlspecialchars($_GET['e']));
		} else {
			$sql .= 'LIMIT 0, 10';
		}

		$orders = $core->getDatabase()->query($sql, []);

		if (empty($orders)) {
			$content .= '<h2>Žádní další uživatelé</h2>';
		} else {
			foreach ($orders as $v) {
				$content .= '
					<article class="user-box">
					<h4>' . $v[0] . '</h4>
					<p class="order-user">' . $v[1] . ' ' . $v[2] . '</p>
					<p class="order-user">Status: ' . ($v[5] == 1 ? 'Povolen' : 'Zakázán') . '</p>
					<section class="user-buttons">
					<form class="user-button" action="uzivatel/zmenaudaju/index.php" method="POST">
					<input type="hidden" name="id" value="' . $v[4] . '">
					<input type="submit" value="Upravit">
					</form>
					<form class="user-button" action="administrace/uzivatele/index.php" method="POST">
					<input type="hidden" name="action" value="deleteUser">
					<input type="hidden" name="id" value="' . $v[4] . '">
					<input type="submit" value="' . ($v[5] == 1 ? 'Zakázat' : 'Povolit') . '">
					</form>
					<form class="user-button remUser" action="administrace/uzivatele/index.php" method="POST">
					<input type="hidden" name="action" value="removeUser">
					<input type="hidden" name="id" value="' . $v[4] . '">
					<input type="submit" value="Odebrat">
					</form>
					</section>
					</article>
				';
			}
			
		}
		$content .= '<div class="nav-buttons"><button onclick="location.href = &quot;administrace/uzivatele?' . $es[0] . '&quot;">←</button><button onclick="location.href = &quot;administrace/uzivatele?' . $es[1] . '&quot;">→</button></div>';
	} else {
		header('Location: ../login');
		exit(1);
	}
} else {
	header('Location: ../login');
	exit(1);
}

?>
