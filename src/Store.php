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
			$GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
			$this->setName($new_name);
		}
		function addBrand($brand) {
			$GLOBALS['DB']->exec("INSERT INTO brands_store (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
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
		static function find($search_id) {
			$found_store = null;
			$stores = Store::getAll();
			foreach($stores as $store) {
				$store_id = $store->getId();
				if ($store_id == $search_id) {
					$found_store = $store;
				}
			}
			return $found_store;
		}
		function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
				JOIN brands_store ON (brands_store.store_id = stores.id)
				JOIN brands ON (brands.id = brands_store.brand_id)
				WHERE stores.id = {$this->getId()};");
            $brands = array();
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }
		function delete() {
			$GLOBALS['DB']->exec("DELETE FROM brands_store WHERE store_id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
		}
	}
?>
