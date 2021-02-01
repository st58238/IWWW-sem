<?php

require_once(__DIR__ . '/irecord.interface.php');

class Order implements IRecord {

	private $id;
	private $user;
	private $time;
	private $email;
	private $name;
	private $surname;
	private $phone;
	private $street;
	private $city;
	private $zip;
	private $country;
	private $delivery;
	private $payment;
	
	function __construct(?int $id, ?int $user, ?string $time, string $email, string $name, string $surname, string $phone, string $street, string $city, int $zip, int $country, int $delivery, int $payment) {
		$this->id = $id;
		$this->user = $user;
		$this->time = $time;
		$this->email = $email;
		$this->name = $name;
		$this->surname = $surname;
		$this->phone = $phone;
		$this->street = $street;
		$this->city = $city;
		$this->zip = $zip;
		$this->country = $country;
		$this->delivery = $delivery;
		$this->payment = $payment;
	}

	function assignUser(User $u) {
		$this->user = $u->getId();
	}

	function getId(): int {
		return $this->id;
	}

	function getUser(): int {
		return $this->user;
	}

	function getTime(): int {
		return $this->time;
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

	function getPhone(): string {
		return $this->phone;
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

	function getDelivery(): int {
		return $this->delivery;
	}

	function getPayment(): bool {
		return $this->payment;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_order'] = $this->id;
		$vals['id_user'] = $this->user;
		$vals['time'] = $this->time;
		$vals['email'] = $this->email;
		$vals['name'] = $this->name;
		$vals['surname'] = $this->surname;
		$vals['phone'] = $this->phone;
		$vals['street'] = $this->street;
		$vals['city'] = $this->city;
		$vals['zip'] = $this->zip;
		$vals['country'] = $this->country;
		$vals['delivery'] = $this->delivery;
		$vals['payment'] = $this->payment;

		return $vals;
	}

	static function getTableName(): string {
		return 'orders';
	}

	static function getPrimaryColumn(): string {
		return 'id_order';
	}

}

?>