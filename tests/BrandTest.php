<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Brand.php";
	require_once "src/Store.php";

	$server = 'mysql:host=localhost:8889;dbname=shoes_test';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	class BrandTest extends PHPUnit_Framework_TestCase {
		protected function teardown() {
			Brand::deleteAll();
			// Store::deleteAll();
		}
		function test_save() {
			$name = "Nike";
			$test_brand = new Brand($name);
			$test_brand->save();

			$result = Brand::getAll();

			$this->assertEquals([$test_brand], $result);
		}
		function test_find() {
			$name = "Nike";
			$name2 = "Addidas";
			$id = 1;
			$id2 = 2;
			$test_brand = new Brand($name, $id);
			$test_brand2 = new Brand($name2, $id2);
			$test_brand->save();
			$test_brand2->save();
			$result = Brand::find($test_brand->getId());

			$this->assertEquals($test_brand, $result);
		}
		function test_getId() {
			$name = "Nike";
			$id = 1;
			$test_brand = new Brand($name, $id);
			$test_brand->save();

			$result = $test_brand->getId();

			$this->assertEquals(true, is_numeric($result));
		}
		function test_getAll() {
			$name = "Nike";
			$id = 1;
			$test_brand = new Brand($name, $id);
			$test_brand->save();

			$name2 = "Addidas";
			$id2 = 2;
			$test_brand2 = new Brand($name, $id);
			$test_brand2->save();

			$result = Brand::getAll();

			$this->assertEquals([$test_brand, $test_brand2], $result);
		}
		function test_addStore(){
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $test_brand->addStore($test_store);
            
            $this->assertEquals($test_brand->getStores(), [$test_store]);
        }

	}
?>
