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
			$id = 1;
			$test_brand = new Brand($name, $id);
			$test_brand->save();

			$result = Brand::getAll();

			$this->assertEquals([$test_brand], $result);
		}
	}
?>