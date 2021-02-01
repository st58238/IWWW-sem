<?php

require_once(__DIR__ . '/model.php');
require_once(__DIR__ . '/system/library.lib.php');
require_once(__DIR__ . '/system/iexport.lib.php');

class Control {

	private $conn;

	function __construct(Database &$conn = null) {
		if ($conn === null) {
			$this->conn = new Database();
		} else {
			$this->conn = $conn;
		}
	}

	function getConn() {
		return $this->conn;
	}

	function insertRecord(IRecord &$rec): ?int {
		$vals = $rec->toArray();

		$i = $this->conn->insertSingleNewRow($rec->getTableName(), $vals, false);

		return $i;
	}

	function updateRecord(IRecord &$oldRec, IRecord &$newRec): ?int {
		$old = $oldRec->toArray();
		$new = $newRec->toArray();

		if (array_values($old)[0] !== array_values($new)[0]) {
			debug('Mismatching id, falling back to old primary ID.');
		}

		$diff = recordDifference($oldRec, $newRec);

		$i = $this->conn->update($oldRec->getTableName(), $oldRec->getPrimaryColumn(), $oldRec->toArray()[$oldRec->getPrimaryColumn()], $diff);

		return $i;
	}

	function deleteRecord(IRecord &$rec): ?int {
		$vals = $rec->toArray();

		$table = $rec->getTableName();
		$col = $rec->getPrimaryColumn();
		$id = array_shift($vals);

		$i = $this->conn->delete($table, $col, $id);

		return $i;
	}

	function getTagById(int $id): ?Tag {
		$v = $this->conn->query('SELECT id_tag, text, priority, display FROM tag WHERE id_tag = ? LIMIT 1', [$id]);
		
		if ($v === null) {
			return null;
		}

		$v = $v[0];

		return new Tag($v[0], $v[1], $v[2], $v[3]);
	}

	function &getAllTags(bool $override = false): array {
		$req = $this->conn->query('SELECT id_tag, text, priority, display FROM tag ' . ($override ? '' : 'WHERE display = 1') . ' ORDER BY priority DESC, text ASC');
		$tags = array();

		foreach ($req as $v) {
			$tags[] = new Tag($v[0], $v[1], $v[2], $v[3]);
		}
		
		return $tags;
	}

	function &getAllProducts(?array $tags = null, ?int $limit = null): array {
		$sql = 'SELECT id_product, name, description, picture, quantity, unit, stock, price, discount_price, display, CONCAT(\',\',GROUP_CONCAT(id_tag SEPARATOR \',\'),\',\') AS en FROM products NATURAL JOIN product_tags WHERE display = 1 GROUP BY id_product HAVING ';
		$vals = array();

		if ($tags === null || empty($tags)) {
			$sql = 'SELECT id_product, name, description, picture, quantity, unit, stock, price, discount_price, display FROM products WHERE display = 1 GROUP BY id_product';
		} else {
			foreach ($tags as $t) {
				$sql .= 'en LIKE \'%,' . $t->getId() . ',%\' AND ';
			}
			$sql = substr($sql, 0, -4);
		}

		if ($limit !== null) {
			$sql .= ' LIMIT ?';
			$vals[] = abs((int) $limit);
		}

		$req = $this->conn->query($sql, $vals);
		$products = array();

		foreach ($req as $p) {
			$products[] = new Product($p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8], $p[9], $this->getProductTags($p[0]));
		}
		
		return $products;
	}

	function getProductById(int $id): ?Product {
		$v = $this->conn->query('SELECT id_product, name, description, picture, quantity, unit, stock, price, discount_price, display FROM products WHERE id_product = ' . $id, array());

		if ($v == null) {
			return null;
		}

		$v = $v[0];

		return new Product($v[0], $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9], $this->getProductTags($v[0]));
	}

	function &getProductTags(int $id, ?int $limit = null): array {
		$req = $this->conn->query('SELECT id_tag, text FROM tag NATURAL JOIN product_tags WHERE id_product = ? AND tag.display = 1 ORDER BY priority DESC' . (($limit == null) ? '' : ' LIMIT ' . abs($limit)), [$id]);
		return $req;
	}

	function insertOrder(array $order, array $cart, ?int $uid = null): ?Order {
		$id = null;
		if ($this->conn->startTransaction()) {
			try {
				$id = (int) (date('ymd') . str_pad((string) rand(0, 999), 3, '0', STR_PAD_LEFT));
				$count = 0;

				while (!empty($this->conn->query('SELECT id_order FROM orders WHERE id_order = ?', [$id])) && $count < 1000) {
					$id = (int) ('2' . date('ymd') . str_pad((string) rand(0, 999), 3, '0', STR_PAD_LEFT));
				}
				unset($count);

				$orderO = new Order($id, $uid, null, $order['email'], $order['name'], $order['surname'], $order['phone'], $order['street'], $order['city'], $order['zip'], $order['country'], $order['delivery'], $order['payment']);

				if ($_SESSION['user'] !== null) {
					$orderO->assignUser($_SESSION['user']);
				}

				$oid = $this->insertRecord($orderO);

				$altAddr = new AltAddress(null, $oid, $order['alt-street'], $order['alt-city'], $order['alt-zip'], $order['alt-country']);

				if ($altAddr->isValid()) {
					$altid = $this->insertRecord($altAddr);
				}

				$ins = 'INSERT INTO order_products VALUES';
				$vals = array();
				foreach ($_SESSION['cart'] as $v) {
					$ins .= '(?, ?, ?, (SELECT price FROM products WHERE id_product = ? LIMIT 1), (SELECT discount_price FROM products WHERE id_product = ? LIMIT 1)), ';
					$vals[] = $oid;
					$vals[] = $v['id'];
					$vals[] = $v['count'];
					$vals[] = $v['id'];
					$vals[] = $v['id'];
				}
				$ins = substr($ins, 0, -2);

				$rid = $this->conn->exec($ins, $vals, false);

				$this->conn->commit();
			} catch (PDOException $e) {
				$this->conn->rollback();
				return null;
			}
		}

		return $this->getOrderById($id);
	}

	function getOrderById(int $id): ?Order {
		$v = $this->conn->query('SELECT id_order, id_user, time, email, name, surname, phone, street, city, zip, country, delivery, payment FROM orders WHERE id_order = ?', [$id]);

		if (!empty($v)) {
			$v = $v[0];
		} else {
			return null;
		}

		$order = null;

		try {
			$order = new Order((int) $v[0], (int) $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], (int) $v[9], (int) $v[10], (int) $v[11], (int) $v[12]);
		} catch (Trowable $e) {
			$order = null;
		}

		return $order;
	}

	function getAltAddress($id): ?AltAddress {
		$v = $this->conn->query('SELECT id_alt_address, id_order, alt_street, alt_city, alt_zip, alt_country FROM alt_address WHERE id_order = ?', [$id]);

		if (!empty($v)) {
			$v = $v[0];
		
			return new AltAddress($v[0], $v[1], $v[2], $v[3], $v[4], $v[5]);
		}
		return null;
	}

	function getUserById(int $id): ?User {
		$v = $this->conn->query('SELECT id_user, email, users.name, surname, phone, city, street, zip, country, role.value, password FROM users JOIN role ON role.id_role = users.id_role WHERE id_user = ?', [$id]);

		if (isset($v[0])) {
			$v = $v[0];
			return new User($v[0], $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9]);
		}

		return null;
	}

	function getUserByMail(string $mail): ?User {
		$v = $this->conn->query('SELECT id_user, email, users.name, surname, phone, city, street, zip, country, role.value, password FROM users JOIN role ON role.id_role = users.id_role WHERE email LIKE ?', [$mail]);

		if (isset($v[0])) {
			$v = $v[0];
			return new User($v[0], $v[1], $v[2], $v[3], $v[4], $v[5], $v[6], $v[7], $v[8], $v[9]);
		}

		return null;
	}

	function getUserPasswordById(int $id): ?string {
		$pass = $this->conn->query('SELECT password FROM users WHERE id_user = ? AND active = 1 LIMIT 1', [$id]);
		if ($pass !== null) {
			if (!empty($pass)) {
				return $pass[0][0];
			}
		}
		return null;
	}

	function getUserPassword(?User $user): ?string {
		if ($user == null) {
			return null;
		}
		return $this->getUserPasswordById($user->getId());
	}

	function authUser(string $mail, string $pass): ?User {
		$v = $this->getUserByMail($mail);
		$hash = $this->getUserPassword($v);
		
		if ($v != null && $hash != null) {
			if (password_verify($pass, $hash)) {
				return $v;
			}
		}

		return null;
	}

	function logout(): void {
		sessionRestart();
	}

	function insertUser(User $user, string $hash, bool $hashed = true): ?User {
		if (!$hashed) {
			$hash = password_hash($hash, PAGE_SECURITY_ALGO, PAGE_SECURITY_ALGO_OPTIONS);
		}

		$u = null;

		try {
			$vals = array(null, $user->getEmail(), $user->getName(), $user->getSurname(), $user->getPhone(), $user->getStreet(), $user->getCity(), (int) $user->getZip(), (int) $user->getCountryCode(), 0, $hash);

			$u = $this->conn->exec('INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)', $vals);
		} catch (Throwable $e) {
			debug($e);
			$u = null;
		}
		
		if ($u === null) return null;
		return $this->getUserById($u);
	}

	function updateUser(User $old, User $new): ?User {
		if ($old->getId() !== $new->getId()) {
			return null;
		}
		
		$id = $this->conn->exec('UPDATE users SET email = ?, name = ?, surname = ?, phone = ?, street = ?, city = ?, zip = ?, country = ? WHERE id_user = ?', [$new->getEmail(), $new->getName(), $new->getSurname(), $new->getPhone(), $new->getStreet(), $new->getCity(), $new->getZip(), $new->getCountry(), $old->getId()]);

		if ($id === $old->getId()) {
			return $new;
		}
		return $old;
	}

	function updatePassword(User $u, string $password, bool $hashed = true): ?User {
		if (!$hashed) {
			$password = password_hash($password, PAGE_SECURITY_ALGO, PAGE_SECURITY_ALGO_OPTIONS);
		}
		
		$this->conn->exec('UPDATE users SET password = ? WHERE id_user = ?', array($password, $u->getId()));

		return $u;
	}

	function deleteUser(User $u): bool {
		$ret = $this->conn->exec('UPDATE users SET active = 0 WHERE id_user = ?', [$u->getId()]);
		if ($ret != 0 && $ret !== null) {
			return true;
		}
		return false;
	}

	function removeUser(int $id): bool {
		$ret = $this->conn->exec('DELETE FROM users WHERE id_user = ?', [$id]);
		if ($ret != 0 && $ret !== null) {
			return true;
		}
		return false;
	}

	function changeUserStatus(int $id): ?int {
		return $this->conn->exec('UPDATE users SET active = ABS(active - 1) WHERE id_user = ?', [$id]);
	}

	function deleteProduct(int $id): ?int {
		return $this->conn->exec('UPDATE products SET display = ABS(display - 1) WHERE id_product = ?', [$id]);
	}

	function removeProduct(int $id): ?int {
		return $this->conn->exec('DELETE FROM products WHERE id_product = ?', [$id]);
	}

	function updateProduct(Product $o, Product $n): ?int {
		return $this->updateRecord($o, $n);
	}

	function &getAllAndSelectedTags($id): array {
		$arr = [[], []];
		
		foreach ($this->getAllTags() as $v) {
			$arr[0][$v->getId()] = $v;
		}
		foreach ($this->conn->query('SELECT id_tag FROM product_tags WHERE id_product = ?', [$id]) as $k) {
			$arr[1][$k[0]] = 1;
		}

		return $arr;
	}

	function addProductTag(int $id, int $tagId): ?int {
		return $this->conn->exec('INSERT INTO product_tags VALUES (?, ?)', [$id, $tagId]);
	}

	function removeProductTag(int $id, int $tagId): ?int {
		return $this->conn->exec('DELETE FROM product_tags WHERE id_product = ? AND id_tag = ?', [$id, $tagId]);
	}

	function exportEshop(): string {
		$res = $this->conn->query('SELECT products.*, id_tag, text, priority FROM products NATURAL JOIN product_tags NATURAL JOIN tag');
		$arr = array();

		foreach ($res as $key => &$v) {
			if (!array_key_exists((int) $v[0], $arr)) {
				$arr[(int) $v[0]]['name'] = $v[1];
				$arr[(int) $v[0]]['desc'] = $v[2];
				$arr[(int) $v[0]]['picture'] = $v[3];
				$arr[(int) $v[0]]['pictureData'] = jexportImage(__DIR__ . '/../img/eshop/' . $v[3]);
				$arr[(int) $v[0]]['unit'] = $v[5];
				$arr[(int) $v[0]]['quantity'] = $v[4];
				$arr[(int) $v[0]]['stock'] = $v[6];
				$arr[(int) $v[0]]['price'] = $v[7];
				$arr[(int) $v[0]]['discountPrice'] = $v[8];
				$arr[(int) $v[0]]['display'] = $v[9];
			}
			$arr[(int) $v[0]]['tags'][$v[10]] = [$v[11], $v[12]];
		}
		
		return jexport($arr);
	}

	function importEshop(string $json, bool $append = true): array {
		$control = Core::getInstance()->getControl();
		$arr = jimport($json);

		if (!$append) {
			$control->truncProducts(true);
		}

		foreach ($arr as $key => &$v) { 
			$prod = new Product(null, $v['name'], $v['desc'], $v['picture'], (int) $v['quantity'], $v['unit'], (bool) $v['stock'], (float) $v['price'], (float) $v['discountPrice'], (bool) $v['display']);

			$pid = $this->insertRecord($prod);
			
			jimportImage(__DIR__ . '/../img/eshop/' . $v['picture'], $v['pictureData']);
			foreach ($v['tags'] as $key => $t) {
				$tag = new Tag(null, $t[0], $t[1]);
				$tag = new Tag($this->searchOrInsertTag($tag), $t[0], $t[1]);
				$tid = $this->conn->exec('INSERT INTO product_tags VALUES (?, ?)', [$pid, $tag->getId()]);
			}
		}

		return $arr;
	}

	private function truncProducts(bool $really = false) {
		if ($really) {
			try {
				$db = Core::getInstance()->getDatabase();
				$db->startTransaction();
				$db->exec('DELETE FROM products');
				$db->exec('DELETE FROM product_tags');
				$db->commit();
			} catch (Throwable $e) {
				Core::getInstance()->getDatabase()->rollback();
			}
		}
	}

	private function searchOrInsertTag(Tag $tag): int {
		$id = -1;
		
		$id = $this->conn->query('SELECT id_tag FROM tag WHERE text LIKE ? LIMIT 1', [$tag->getText()]);

		if (empty($id)) {
			$id = $this->insertRecord($tag);
			return $id;
		}
		
		return $id[0][0];
	}

	function finishOrder(int $id): int {
		return $this->conn->exec('UPDATE orders SET finished = ABS(finished - 1) WHERE id_order = ?', [$id]);
	}

	function removeOrder(int $id): int {
		return $this->conn->exec('DELETE FROM orders WHERE id_order = ?', [$id]);
	}

	function hideTag(int $id): int {
		return $this->conn->exec('UPDATE tag SET display = ABS(display - 1) WHERE id_tag = ?', [$id]);
	}

}

?>
