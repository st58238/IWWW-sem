<?php

require_once(__DIR__ . '/model/user.class.php');
require_once(__DIR__ . '/system/library.lib.php');

sessionStart();

$pages = array();

{
	$pages[] = ['.', 'Vinárna'];
	$pages[] = ['eshop', 'Eshop'];
	$pages[] = ['kontakt', 'Kontakty'];
	$pages[] = ['kosik', 'Košík'];
}

$header = '<header class="header">
<a href="." id="logo" class="hardlight nolink">Vinárna</a>
<nav>
<div class="nav-fill"></div>
<div class="sub-nav">
:links:
</div>
<div class="nav-fill">
' . (($_SESSION['user'] != null) ? '<a href="uzivatel" class="nolink"><p class="white hardlight">' . $_SESSION['user']->getSurname() . '</p></a>' : '<a href="login" class="nolink"><p class="white hardlight">Login</p></a>') . '
</div>
</nav>
</header>';

{
	$links = '';
	foreach ($pages as $v) {
		$links .= '<a href="' . $v[0] . '" class="nolink"><p class="white hardlight">' . $v[1] . '</p></a>';
	}
	$header = str_replace(':links:', $links, $header);
}

$sideLeft = '<aside class="sidebar-left">';
$sideRight = '<aside class="sidebar-right">';

if ($_SESSION['user'] !== null) {
	$sideRight = '<aside class="sidebar-right"><a class="nolink logout" style="color: red;" href="login/index.php?action=logout"><p>Odhlásit se</p></a>';
}

$mainOpen = '<div class="main">';
$mainClose = '</div>';

$footer = '<footer class="footer white">
<p>Tato práce je odevzdána jako semestrální práce pro předmět IWWW - Návrh a tvorba WWW stránek.</p>
<small>Autor: st58238</small>
</footer>';

define('HEADER', $header);
define('SIDEBAR_LEFT', $sideLeft . '</aside>');
define('SIDEBAR_LEFT_OPEN', $sideLeft);
define('SIDEBAR_LEFT_CLOSE', '</aside>');
define('MAIN_OPEN', $mainOpen);
define('MAIN_CLOSE', $mainClose);
define('SIDEBAR_RIGHT', $sideRight . '</aside>');
define('SIDEBAR_RIGHT_OPEN', $sideRight);
define('SIDEBAR_RIGHT_CLOSE', SIDEBAR_LEFT_CLOSE);
define('FOOTER', $footer);

$pplDelivery = '<article class="cart-item">
<h2 class="confirm-name">Doprava - PPL</h2>
<p class="confirm-nonvat">Bez DPH: 90,91 Kč</p>
<p class="confirm-vat">DPH: 19,09 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 110,00 Kč</p>
</article>';

$pplPayment = '<article class="cart-item">
<h2 class="confirm-name">Dobírka - PPL</h2>
<p class="confirm-nonvat">Bez DPH: 16,53 Kč</p>
<p class="confirm-vat">DPH: 3,47 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 20,00 Kč</p>
</article>';

$cpDelivery = '<article class="cart-item">
<h2 class="confirm-name">Doprava - Česká pošta</h2>
<p class="confirm-nonvat">Bez DPH: 66,12 Kč</p>
<p class="confirm-vat">DPH: 13,88 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 80,00 Kč</p>
</article>';

$cpPayment = '<article class="cart-item">
<h2 class="confirm-name">Dobírka - Česká pošta</h2>
<p class="confirm-nonvat">Bez DPH: 16,53 Kč</p>
<p class="confirm-vat">DPH: 3,47 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 20,00 Kč</p>
</article>';

$bankPayment = '<article class="cart-item">
<h2 class="confirm-name">Bankovní převod</h2>
<p class="confirm-nonvat">Bez DPH: 0,00 Kč</p>
<p class="confirm-vat">DPH: 0,00 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 0,00 Kč</p>
</article>';

$osPayment = '<article class="cart-item">
<h2 class="confirm-name">Platba při převzetí</h2>
<p class="confirm-nonvat">Bez DPH: 0,00 Kč</p>
<p class="confirm-vat">DPH: 0,00 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 0,00 Kč</p>
</article>';

$osDelivery = '<article class="cart-item">
<h2 class="confirm-name">Odobní odběr Medlešice</h2>
<p class="confirm-nonvat">Bez DPH: 0,00 Kč</p>
<p class="confirm-vat">DPH: 0,00 Kč</p>
<p class="confirm-fullprice">Cena vč. DPH: 0,00 Kč</p>
</article>';

define('DELIVERY_PPL', array($pplDelivery, 110.0));
define('PAYMENT_PPL', array($pplPayment, 20.0));
define('DELIVERY_CP', array($cpDelivery, 80.0));
define('PAYMENT_CP', array($cpPayment, 20.0));
define('DELIVERY_OS', array($osDelivery, 0.0));
define('PAYMENT_OS', array($osPayment, 0.0));
define('PAYMENT_BANK', array($bankPayment, 0.0));

function composeTags(array $tags, bool $selected = false): string {
	$html = '<section class="filters"><ul class="tags">';

	foreach ($tags as $t) {
		if ($selected) {
			$html .= '<li data-id="' . $t[0] . '" data-selected="1">' . $t[1] . '<span class="tag-bullet">&bull;</span></li>';
		} else {
			$html .= '<li data-id="' . $t[0] . '">' . $t[1] . '<span class="tag-bullet">&bull;</span></li>';
		}
	}

	$html .= '</ul></section>';
	return $html;
}

function backButton(string $location = null, string $fallback = null): string {
	if (!isset($_SERVER['HTTP_REFERER'])) {
		$location = $fallback;
	}

	if ($location === null && isset($_SERVER['HTTP_REFERER'])) {
		$location = $_SERVER['HTTP_REFERER'];
	}

	if ($location === null) {
		$location = 'uzivatel';
	}

	return '<button onclick="location.href = &quot;' . $location . '&quot;">&lt;</button>';;
}

?>
