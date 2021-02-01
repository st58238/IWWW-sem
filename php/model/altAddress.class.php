<?php

require_once(__DIR__ . '/irecord.interface.php');

class AltAddress implements IRecord{

	private $id;
	private $idOrder;
	private $street;
	private $city;
	private $zip;
	private $country;
	
	function __construct(?int $id, int $order, string $street, string $city, int $zip, int $country) {
		$this->id = $id;
		$this->idOrder = $order;
		$this->street = $street;
		$this->city = $city;
		$this->zip = $zip;
		$this->country = $country;
	}

	function getId(): int {
		return $this->id;
	}

	function getOrder(): int {
		return $this->idOrder;
	}

	function getStreet(): string {
		return $this->street;
	}

	function getCity(): string {
		return $this->city;
	}

	function getZip(): int {
		return $this->zip;
	}

	function getCountry(): int {
		return $this->country;
	}

	function isValid(): bool {
		return !empty($this->street) || !empty($this->city) || !$this->zip <= 0;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_alt_address'] = $this->id;
		$vals['id_order'] = $this->idOrder;
		$vals['alt_street'] = $this->street;
		$vals['alt_city'] = $this->city;
		$vals['alt_zip'] = $this->zip;
		$vals['alt_country'] = $this->country;

		return $vals;
	}

	static function getTableName(): string {
		return 'alt_address';
	}

	static function getPrimaryColumn(): string {
		return 'id_alt_address';
	}

}

?>