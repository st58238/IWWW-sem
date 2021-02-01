<?php

require_once(__DIR__ . '/../model/irecord.interface.php');

function sessionStart(): void {
	if (!isset($_SESSION)) {
		session_start();

		if (!isset($_SESSION['tags'])) {
			$_SESSION['tags'] = array();
		}

		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
		}

		if (!isset($_SESSION['user'])) {
			$_SESSION['user'] = null;
		}
	}
}

function sessionEnd(): void {
	if (isset($_SESSION)) {
		session_unset();
		session_destroy();
	}
}

function sessionRestart(): void {
	sessionEnd();
	sessionStart();
}

function clearArrayValues(array &$arr): void {
	foreach ($arr as $k => $v) {
		if (is_array($v)) {
			clearArrayValues($v);
		} else {
			if ($v === null) {
				unset($arr[$k]);
			}
		}
	}
}

function recordDifference(IRecord $old, IRecord $new): array {
	$diff = array();
	$o = $old->toArray();
	$n = $new->toArray();

	foreach (array_intersect(array_keys($o), array_keys($n)) as $k) {
		if ($o[$k] === $n[$k]) {
			continue;
		} else {
			$diff[$k] = $n[$k];
		}
	}

	return $diff;
}

/**
* stackoverflow.com: How to check if PHP array is associative or sequential?
* https://stackoverflow.com/questions/173400
*/
function isAssoc($arr): bool {
	if (array() === $arr) return false;
	return array_keys($arr) !== range(0, count($arr) - 1);
}

function VAT(float $price, float $vat = VAT): float {
	return $price - ($price / (1 + $vat / 100));
}

function nonVAT(float $price, float $vat = VAT): float {
	return $price / (1 + $vat / 100);
}

?>
