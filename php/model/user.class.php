<?php

require_once( __DIR__ . '/../system/defines.lib.php');

require_once(__DIR__ . '/irecord.interface.php');

class User implements IRecord {
	private $id;
	private $email;
	private $name;
	private $surname;
	private $phone;
	private $street;
	private $city;
	private $zip;
	private $country;
	private $role;

	function __construct(?int $id, string $email, string $name, string $surname, ?string $phone = null, ?string $street = null, ?string $city = null, ?int $zip = null, ?int $country = null, int $role = 0) {
		$this->id = $id;
		$this->email = $email;
		$this->name = $name;
		$this->surname = $surname;
		$this->phone = $phone;
		$this->street = $street;
		$this->city = $city;
		$this->zip = $zip;
		$this->country = $country;
		$this->role = $role;
	}

	function getId(): ?int {
		return $this->id;
	}

	function getEmail(): string {
		return $this->email;
	}

	function getName(): string {
		return $this->name;
	}

	function getSurname(): string {
		return $this->surname;
	}

	function getFullName(): string {
		return $this->name . ' ' . $this->surname;
	}

	function getPhone(): ?string {
		return $this->phone;
	}

	function getStreet(): ?string {
		return $this->street;
	}

	function getCity(): ?string {
		return $this->city;
	}

	function getZip(): ?string {
		return $this->zip;
	}

	function getCountry(): ?string {
		return COUNTRIES[$this->country];
	}

	function getCountryCode(): ?int {
		return $this->country;
	}

	function getRole(): int {
		return $this->role;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_user'] = $this->id;
		$vals['email'] = $this->email;
		$vals['name'] = $this->name;
		$vals['surname'] = $this->surname;
		$vals['phone'] = $this->phone;
		$vals['street'] = $this->street;
		$vals['city'] = $this->city;
		$vals['zip'] = $this->zip;
		$vals['country'] = $this->country;
		$vals['id_role'] = $this->role;

		return $vals;
	}

	static function getTableName(): string {
		return 'users';
	}

	static function getPrimaryColumn(): string {
		return 'id_user';
	}

}

?>