<?php

require_once(__DIR__ . '/../core.php');
require_once(__DIR__ . '/../html.php');

sessionStart();

$content = '';
$pid = -1;

if (isset($_SESSION['user'])) {
	if (!empty($_SESSION['user']) && $_SESSION['user'] !== null && $_SESSION['user']->getRole() >= 500) {
		$core = Core::getInstance();
		$control = $core->getControl();


		if (isset($_POST['action']) && isset($_POST['text']) && isset($_POST['priority'])) {
			$text = htmlspecialchars($_POST['text']);
			$prio = htmlspecialchars($_POST['priority']);

			if ($_POST['action'] == 'addTag' && !empty($text) && !empty($prio)) {
				$tag = new Tag(null, $text, $prio);
				$control->insertRecord($tag);
			} else if ($_POST['action'] == 'editTag' && isset($_POST['id'])) {
				$id = (int) htmlspecialchars($_POST['id']);
				$newtag = new Tag($id, $text, $prio);
				$oldtag = $control->getTagById($id);
				$control->updateRecord($oldtag, $newtag);
			}
		} else if (isset($_POST['action']) && $_POST['action'] == 'deleteTag') {
			$id = (int) htmlspecialchars($_POST['id']);
			$tag = $control->getTagById($id);
			$control->deleteRecord($tag);
			header('Location: .');
			exit(0);
		} else if (isset($_POST['action']) && $_POST['action'] == 'hideTag' && isset($_POST['id'])) {
			$id = (int) htmlspecialchars($_POST['id']);
			$control->hideTag($id);
			header('Location: .');
			exit(0);
		}

		$content .= '<section class="user-info">
		<p class="order-user">' . buildTags() . '</p>';



		$content .= '<div class="modal" id="modalbox">
			<form action="administrace/tagy/index.php" method="POST">
			<div class="modal-header">
			<h3 id="passchange-h">Změna údajů</h3>
			</div>
			<div class="modal-content">
			<input type="hidden" name="action" value="editTag">
			<input type="hidden" name="id">
			<div class="labeled-input"><label for="name">Text: </label>
			<input type="text" name="text" class="input input-text" required="required"></div>
			<div class="labeled-input"><label for="priority">Priorita: </label>
			<input type="number" name="priority" min="0" max="' . PHP_INT_MAX . '" step="1" class="input input-number" required="required"></div>
			</div>
			<div class="modal-footer">
			<input type="submit" value="Potvrdit">
			</form>
			<div class="hCont">
			<form action="administrace/tagy/index.php" id="delTag" method="POST">
			<input type="submit" value="Odebrat tag" id="removeTagButton">
			<input type="hidden" name="action" value="deleteTag">
			<input type="hidden" id="remId" name="id">
			</form>
			<form action="administrace/tagy/index.php" id="hTag" method="POST">
			<input type="submit" value="Změnit viditelnost tagu" id="hideTagButton">
			<input type="hidden" name="action" value="hideTag">
			<input type="hidden" id="hidId" name="id">
			</form>
			</div>
		</div>';
		
	} else {
		header('Location: ../login');
		exit(1);
	}
} else {
	header('Location: ../login');
	exit(1);
}

function buildTags(?int $id = null): string {
	$control = Core::getInstance()->getControl();
	$content = '<section class="filters"><ul class="tags">';
	if ($id === null) {
		foreach ($control->getAllTags(true) as $t) {
			$content .= '<li data-id="' . $t->getId() . '" data-name="' . $t->getText() . '" data-priority="' . $t->getPriority() . '" class="tagchange' . ($t->getDisplay() ? '' : ' ghost') . '">' . $t->getText() . ' (' . $t->getPriority() . ')<span class="tag-bullet">&bull;</span></li>';
		}
	}
	
	return $content . '</ul></section>';
}

?>
