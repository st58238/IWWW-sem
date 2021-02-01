<?php

require_once(__DIR__ . '/irecord.interface.php');

class Question implements IRecord {

	private $id;
	private $title;
	private $text;
	private $user;
	private $order;

	function __construct(int $id, ?string $title, string $text, ?int $user, ?int $order) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		$this->user = $user;
		$this->order = $order;
	}

	function getId(): int {
		return $this->id;
	}

	function getTitle(): ?string {
		return $this->title;
	}

	function getText(): string {
		return $this->text;
	}

	function getUser(): ?int {
		return $this->user;
	}

	function getOrder(): ?int {
		return $this->order;
	}

	function toArray(): array {
		$vals = array();

		$vals['id_question'] = $this->id;
		$vals['title'] = $this->title;
		$vals['text'] = $this->text;
		$vals['id_user'] = $this->user;
		$vals['id_order'] = $this->order;

		return $vals;
	}

	static function getTableName(): string {
		return 'questions';
	}

	static function getPrimaryColumn(): string {
		return 'id_question';
	}

}

?>