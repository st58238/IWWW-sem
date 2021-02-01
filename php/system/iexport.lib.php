<?php

function &jexport(array &$object): string {
	$str = json_encode($object, true);
	return $str;
}

function &jimport(string &$json): array {
	$arr = json_decode($json, true);
	return $arr;
}

function &jexportImage(string $path): string {
	$img = base64_encode(file_get_contents($path));
	return $img;
}

function jimportImage(string $path, string &$data) {
	$ok = file_put_contents($path, base64_decode($data));
	return $ok == false ? false : $ok;
}


?>