<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 500) {
		$core = Core::getInstance();
		$control = $core->getControl();

		if (isset($_GET['action'])) {
			if ($_GET['action'] == 'export') {
				$json = $control->exportEshop();

				/**
				* php.net, Example #1 Forcing a download using readfile()
				* https://www.php.net/manual/en/function.readfile.php
				* Upraveno dle potřeby
				*/
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="export.json"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . mb_strlen($json));
				
				echo $json;
			}
		} else if (isset($_POST['action'])) {
			if ($_POST['action'] == 'import' && isset($_FILES['json'])) {
				if (pathinfo($_FILES['json']['name'])['extension'] == 'json') {
					$over = false;
					if (isset($_POST['overwrite'])) {
						$over = true;
					}
					$control->importEshop(file_get_contents($_FILES['json']['tmp_name']), !$over);
					header('Location: ../produkty');
				}
			}
		}

		$content .= '<div class="correction"><aside class="user-nav">
			<a href="administrace/export/index.php?action=export" class="nolink"><p>Export</p></a>
			<form action="administrace/export/index.php" method="POST"enctype="multipart/form-data">
			<p class="nolink">Import</p>
			<input type="file" name="json">
			<div class="labeled-input"><label for="overwrite">Přepsat databázi</label>
			<input type="hidden" name="action" value="import">
			<input type="checkbox" name="overwrite"></div>
			<input type="submit" value="Importovat">
			</form>
		</aside>';

		$content .= '<section class="user-info">
		</section></div>';
	} else {
		header('Location: ../../login');
		exit(1);
	}
} else {
	header('Location: ../../login');
	exit(1);
}

?>
