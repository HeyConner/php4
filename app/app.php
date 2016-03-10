<?php
	require_once __DIR__."/../vendor/autoload.php";
	require_once __DIR__."/../src/Brand.php";
	require_once __DIR__."/../src/Store.php";

	$app = new Silex\Application();

	$server = 'mysql:host=localhost:8889;dbname=shoes';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	use Symfony\Component\HttpFoundation\Request;
	Request::enableHttpMethodParameterOverride();

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

$app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });
    $app->post("/brands", function() use ($app){
        $new_brand = new Brand($_POST['brand_name']);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });
    $app->post('/delete_brands', function() use ($app){
        Brand::deleteAll();
        return $app['twig']->render('deletedbrand.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });
    $app->post('/delete_stores', function() use ($app){
        Store::deleteAll();
        return $app['twig']->render('deletedstore.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });
    $app->post("/added_stores", function() use ($app){
        $new_store = new Store($_POST['name']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });
		$app->post("/added_brands", function() use ($app) {
				$new_brand = new Brand($_POST['name']);
				$new_brand->save();
				return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
		});
    $app->get('/add_brand', function() use ($app){
        return $app['twig']->render('add_brand.html.twig', array('brands' => Brand::getAll()));
    });
    $app->get('/add_store', function() use ($app){
        return $app['twig']->render('add_store.html.twig', array('stores' => Store::getAll()));
    });

    $app->get('/brands/{id}', function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('stores.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'allStores' => Store::getAll()));
    });

    $app->post('/brands/{id}', function($id) use ($app){
        $brand = Brand::find($id);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('stores.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'allStores' => Store::getAll()));
    });

    $app->get('/stores/{id}', function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('brands.html.twig', array('store' => $store, 'allBrands' => Brand::getAll(), 'brands' => $store->getBrands()));
    });

		$app->post('/stores/{id}', function($id) use ($app){
				$store = Store::find($id);
				$brand = Brand::find($_POST['brand_id']);
				$store->addBrand($brand);
				return $app['twig']->render('brands.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'allBrands' => Brand::getAll()));
		});
		$app->delete('/delete_store/{id}', function($id) use ($app){
				$store = Store::find($id);
				$store->delete();
				return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
		});
		$app->delete('/delete_brand/{id}', function($id) use ($app){
				$brand = Brand::find($id);
				$brand->delete();
				return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
		});
		$app->get('/updateStore/{id}', function($id) use ($app) {
				$store = Store::find($id);
				return $app['twig']->render('updateStoreName.html.twig', array('store' => $store));
		});
		$app->patch('/stores/{id}/updated', function($id) use ($app){
				$store = Store::find($id);
				$new_name = $_POST['name'];
				$store->update($new_name);
				return $app['twig']->render('brands.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'allBrands' => Brand::getAll()));
		});

		return $app;
?>
