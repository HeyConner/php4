<?php
	class Brand {
		private $name;
		private $id;

		function __construct($name, $id = null) {
			$this->name = $name;
			$this->id = $id;
		}
		function setName($new_name) {
			$this->name = (string) $new_name;
		}
		function getName() {
			return $this->name;
		}
		function getId() {
			return $this->id;
		}
		function save() {
			$GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}')");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}
		static function getAll() {
			$returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
			$brands = array();
			foreach($returned_brands as $brand) {
				$name = $brand['name'];
				$id = $brand['id'];
				$new_brand = new Brand($name, $id);
				array_push($brands, $new_brand);
			}
			return $brands;
		}
		static function deleteAll() {
			$GLOBALS['DB']->exec("DELETE FROM brands;");
		}
		static function find($search_id) {
			$found_brand = null;
			$brands = Brand::getAll();
			foreach($brands as $brand) {
				$brand_id = $brand->getId();
				if($brand_id == $search_id) {
					$found_brand = $brand;
				}
				return $found_brand;
			}
			function update($new_name) {
				$GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
				$this->setName($new_name);
			}
			function delete() {
				$GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
				$GLOBALS['DB']->exec("DELETE FROM brands_store WHERE brand_id = {this->getId()};");
			}


			////NEED A JOIN STATEMENT
			function getStores() {
				$query = $GLOBALS['DB']->query("SELECT store_id FROM brands_store WHERE brand_id = {$this->getId()};");

				$stores__ids = $query->fetchAll(PDO::FETCH_ASSOC);

				$stores = array();
				foreach($store_ids as $id) {
					$store_id = $id['store_id'];
					$result = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$store_id};");
					$returned_brands = $result->fetchAll(PDO::FETCH_ASSOC);

					$name = $returned_brands[0]['name'];
					$id = $returned_brands[0]['id'];
					$new_brand = new Brand($name);
					array_push($stores, $new_store);
				}
				return $stores;
			}
		}
	}
?>
