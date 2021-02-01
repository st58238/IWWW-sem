<?php

require_once(__DIR__ . '/defines.lib.php');
require_once(__DIR__ . '/debug.lib.php');

require_once(__DIR__ . '/library.lib.php');

class Database {
	private $conn;

	function __construct() {
		$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

		try {
			$this->conn = new PDO(PDO_DSN, DB_USER, DB_PASSWORD, $options);
		} catch (PDOException $e) {
			debug($e);
		}
	}

	function __destruct() {
		// Try to gracefully destruct the PDO object
		$report = error_reporting();
		try {
			$mode = $this->conn->getAttribute(PDO::ATTR_ERRMODE);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

			error_reporting(null);

			$this->conn->query('KILL CONNECTION_ID()');
			$this->conn->query('KILL CONNECTION CONNECTION_ID()');

			if ($this->conn->errorCode() !== 'HY000') {
				$this->$this->conn->setAttribute(PDO::ATTR_ERRMODE, $mode);
			}
		} catch (Throwable $e) {
			debug($e);
		} finally {
			unset($this->conn);
			$this->conn = null;

			error_reporting($report);
		}
	}

	function &query(string $sql, array $vals = []): array {
		foreach ($vals as &$v) {
			if (is_string($v)) {
				$v = htmlspecialchars($v);
			}
		}

		$arr = array();
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($vals);

		$arr = $stmt->fetchAll(PDO::FETCH_NUM);

		unset($stmt);

		return $arr;
	}

	function exec(string $sql, array $vals = []): int {
		foreach ($vals as &$v) {
			if (is_string($v)) {
				$v = htmlspecialchars($v);
			}
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($vals);
		$count = $stmt->rowCount();
		
		unset($stmt);


		return $this->getLastId() != 0 ? $this->getLastId() : $count;
	}

	function startTransaction(): bool {
		try {
			$this->conn->beginTransaction();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	function commit(): bool {
		return $this->conn->commit();
	}

	function rollback(): bool {
		return $this->conn->rollBack();
	}

	function insert(string $table, array $values, bool $clear = true) {
		return $this->insertSingleNewRow($table, $values, $clear);
	}

	function insertSingleNewRow(string $table, array $values, bool $clear = true): ?int {
		if ($table === 'inforamtion_schema' || $table === 'performance_schema') {
			return null;
		}

		$id = null;

		if (!empty($values)) {
			$table = htmlspecialchars($table);

			if ($clear) {
				clearArrayValues($values);
			}
			
			$sql = 'INSERT INTO ' . $table;
			$vals = array();
			if (isAssoc($values)) {
				$sql .= '(';
				foreach ($values as $k => $v) {
					$sql .= $k . ', ';
				}
				$sql = substr($sql, 0, -2);
				$sql .= ') VALUES (';
				foreach ($values as $k => $v) {
					$vals[] = $v;
					$sql .= '?, ';
				}
				$sql = substr($sql, 0, -2);
				$sql .= ')';
			} else {
				$sql .= ' VALUES (';
				foreach ($values as $v) {
					$vals[] = $v;
					$sql .= '?, ';
				}
				$sql = substr($sql, 0, -2);
				$sql .= ')';
			}

			try {
				$stmt = $this->conn->prepare($sql);
				$stmt->execute($vals);

				$id = $this->conn->lastInsertId();
			} catch (PDOException $e) {
				debug($e);
			}

			unset($stmt);
		}
		return $id;
	}

	function getLastId(): int {
		return $this->conn->lastInsertId();
	}

	function update(string $table, string $col, int $id, array $values): ?int {
		if ($table === 'inforamtion_schema' || $table === 'performance_schema') {
			return null;
		}

		$ids = null;

		if (!empty($values)) {
			clearArrayValues($values);

			$table = htmlspecialchars($table);
			$vals = array();
			$sql = "UPDATE $table SET ";
			$col = htmlspecialchars($col);

			foreach ($values as $k => $v) {
				$sql .= "$k = ?, ";
				$vals[] = $v;
			}

			$sql = substr($sql, 0, strlen($sql) - 2);
			$sql .= " WHERE $col = ?";
			$vals[]= $id;

			try {
				$stmt = $this->conn->prepare($sql);
				$stmt->execute($vals);

				$ids = $this->conn->lastInsertId();
			} catch (PDOException $e) {
				debug($e);
			}

			unset($stmt);
		}
		return $ids;		
	}

	function delete(string $table, string $col, int $id): ?int {
		if ($table === 'inforamtion_schema' || $table === 'performance_schema') {
			return null;
		}

		$ids = null;

		$table = htmlspecialchars($table);
		$col = htmlspecialchars($col);

		try {
			$stmt = $this->conn->prepare("DELETE FROM $table WHERE $col = ?");

			$stmt->execute(array($id));
			$ids = $stmt->rowCount();
		} catch (PDOException $e) {
			debug($e);
		}

		unset($stmt);

		return $ids;
	}

}

?>