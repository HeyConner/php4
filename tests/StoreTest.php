<?php 
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Store.php";
	require_once "src/Brand.php";

	$server = 'mysql:host=localhost:8889;dbname=shoes_test';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	class StoreTest extends PHPUnit_Framework_TestCase {
		protected function tearDown() {
			Store::deleteAll();
			Brand::deleteAll();
		}
		function test_getName() {
			$name = "Dicks";
			$test_store = new Store($name);

			$result = $test_store->getName();

			$this->assertEquals($name, $result);
		}
		function test_setName() {
			$name = "Dicks";
			$test_store = new Store($name);

			$test_store->setName("Sports");
			$result = $test_store->getName();

			$this->assertEquals("Sports", $result);
		}
		function test_getId() {
			$name = "Nike";
			$id = 1;
			$test_store = new Store($name, $id);

			$result = $test_store->getId();

			$this->assertEquals($id, $result);
		}
		function test_save() {
			$name = "Nike";
			$id = 1;
			$test_store = new Store($name, $id);
			$test_store->save();

			$result = Store::getAll();

			$this->assertEquals($test_store, $result[0]);
		}
		function test_getAll() {
			$name = "Nike";
			$name2 = "Addidas";
			$id = 1;
			$id2 = 2;
			$test_store = new Store($name, $id);
			$test_store2 = new Store($name2, $id2);
			$test_store->save();
			$test_store2->save();

			$result = Store::getAll();

			$this->assertEquals([$test_store, $test_store2], $result);
		}
		function test_deleteAll() {
			$name = "Dicks";
            $name2 = "Addidas";
            $id = 1;
            $id2 = 2;
            $test_store = new Store($name, $id);
            $test_store2 = new Store($name2, $id2);
            $test_store->save();
            $test_store2->save();
            Store::deleteAll();

            $result = Store::getAll();

            $this->assertEquals([], $result);
		}
		function test_find() {
			$name = "Dicks";
            $name2 = "Addidas";
            $id = 1;
            $id2 = 2;
            $test_store = new Store($name, $id);
            $test_store2 = new Store($name2, $id2);
            $test_store->save();
            $test_store2->save();
            $result = Store::find($test_store->getId());
            $this->assertEquals($test_store, $result);
		}
	}
?>