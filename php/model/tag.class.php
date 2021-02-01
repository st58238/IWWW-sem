<?php

require_once(__DIR__ . '/irecord.interface.php');

class Tag implements IRecord {

	private $id;
	private $text;
	private $priority;
	private $active;

	function __construct(?int $id, string $text, int $priority = 0, int $active = 1) {
		$this->id = $id;
		$this->text = $text;
		$this->priority = $priority;
		$this->active = $active;
	}

	function getId(): ?int {
		return $this->id;
	}

	function getText(): string {
		return $this->text;
	}

	function getPriority(): int {
		return $this->priority;
	}

	function getDisplay(): bool {
		return $this->active == 1;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_tag'] = $this->id;
		$vals['text'] = $this->text;
		$vals['priority'] = $this->priority;

		return $vals;
	}

	static function getTableName(): string {
		return 'tag';
	}

	static function getPrimaryColumn(): string {
		return 'id_tag';
	}

}

?>