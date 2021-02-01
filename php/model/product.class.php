<?php

require_once(__DIR__ . '/irecord.interface.php');

class Product implements IRecord {
	private $id;
	private $name;
	private $desc;
	private $picture;
	private $quantity;
	private $unit;
	private $stock;
	private $price;
	private $discountPrice;
	private $display;
	private $tags;

	function __construct(?int $id, string $name, string $desc, ?string $picture, int $quantity, string $unit, bool $stock, float $price, ?float $discountPrice, bool $display, array $tags = []) {
		$this->id = $id;
		$this->name = $name;
		$this->desc = $desc;
		$this->picture = $picture;
		$this->quantity = $quantity;
		$this->unit = $unit;
		$this->stock = $stock;
		$this->price = $price;
		$this->discountPrice = empty($discountPrice) ? null : $discountPrice;
		$this->display = $display;
		$this->tags = $tags;
	}

	function getId(): ?int {
		return $this->id;
	}

	function getName(): string {
		return $this->name;
	}

	function getDesc(): string {
		return $this->desc;
	}

	function getPicture(): ?string {
		return $this->picture;
	}

	function getImg(): ?string {
		return $this->picture;
	}

	function getQuantity(): int {
		return $this->quantity;
	}

	function getUnit(): string {
		return $this->unit;
	}

	function getStock(): bool {
		return $this->stock;
	}

	function getPrice(): float {
		return $this->price;
	}

	function getDiscountPrice(): ?float {
		return $this->discountPrice;
	}

	function getDisplay(): bool {
		return $this->display;
	}

	function getCorrectPrice(): float {
		$price = $this->price;
		if ($this->discountPrice > 0 && $this->discountPrice != null) {
			$price = $this->discountPrice;
		}
		
		return $price;
	}

	function getFullPrice(): string {
		return '' . number_format($this->getCorrectPrice(), 2, ',', '') . ' Kč/' . $this->unit;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_product'] = $this->id;
		$vals['name'] = $this->name;
		$vals['description'] = $this->desc;
		$vals['picture'] = $this->picture;
		$vals['quantity'] = $this->quantity;
		$vals['unit'] = $this->unit;
		$vals['stock'] = $this->stock;
		$vals['price'] = $this->price;
		$vals['discount_price'] = $this->discountPrice;
		$vals['display'] = $this->display;

		return $vals;
	}

	static function getTableName(): string {
		return 'products';
	}

	static function getPrimaryColumn(): string {
		return 'id_product';
	}

}

?>