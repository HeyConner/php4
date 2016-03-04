<?php 
	class Store {
		private $name;
		private $id;

		function __construct($name, $id = null) {
			$this->name = $name;
			$this->id = $id;
		}

		function getName() {
			return $this->name;
		}
		function setName($new_name) {
			$this->name = $new_name;
		}
		function getId() {
			return $this->id;
		}
		function save() {
			$GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
		function update($new_name) {
			$GLOBALS['DB']->exec("UPDATE stores SET name = '{new_name}' WHERE id = {$this->getId()};");
		}
		function addBrand($brand) {
			$GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
		}
		static function deleteAll() {
			$GLOBALS['DB']->exec("DELETE FROM stores;");
		}
		static function getAll() {
			$returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
			$stores = array();
			foreach($returned_stores as $store) {
				$name = $store['name'];
				$id = $store['id'];
				$new_store = new Store($name, $id);
				array_push($stores, $new_store);
			}
			return $stores;
		}
	}
?>