<?php

interface IRecord {
	public static function getTableName(): string;
	public static function getPrimaryColumn(): string;
	public function toArray(): array;
}

?>