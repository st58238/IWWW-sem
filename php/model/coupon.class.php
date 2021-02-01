<?php

require_once(__DIR__ . '/irecord.interface.php');

class Coupon implements IRecord {

	private $id;
	private $id_user;
	private $id_product;
	private $code;
	private $uses;
	private $value_constant;
	private $value_percent;
	private $free_shipping;

	function __construct(int $id, ?int $id_user, ?int $id_product, string $code, int $uses, ?float $value_constant, ?float $value_percent, bool $free_shipping = false) {
		$this->id = $id;
		$this->id_user = $id_user;
		$this->id_product = $id_product;
		$this->code = $code;
		$this->uses = $uses;
		$this->value_constant = $value_constant;
		$this->value_percent = $value_percent;
		$this->free_shipping = $free_shipping;
	}

	function getId(): int {
		return $this->id;
	}

	function getIdUser(): ?int {
		return $this->id_user;
	}

	function getIdProduct(): ?int {
		return $this->id_product;
	}

	function getCode(): string {
		return $this->code;
	}

	function getUses(): int {
		return $this->uses;
	}

	function getValueConstant(): ?float {
		return $this->value_constant;
	}

	function getValuePercent(): ?float {
		return $this->value_percent;
	}

	function getFreeShipping(): bool {
		return $this->free_shipping;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_coupon'] = $this->id;
		$vals['id_user'] = $this->id_user;
		$vals['id_product'] = $this->id_product;
		$vals['code'] = $this->code;
		$vals['uses'] = $this->uses;
		$vals['value_constant'] = $this->value_constant;
		$vals['value_percent'] = $this->value_percent;
		$vals['free_shipping'] = $this->free_shipping;

		return $vals;
	}

	static function getTableName(): string {
		return 'coupon';
	}

	static function getPrimaryColumn(): string {
		return 'id_coupon';
	}
	
}

?>