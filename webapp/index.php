<?php
    require_once 'Slim/Slim.php';
    require_once 'telemetry.php';
	require_once 'foody.php';
    
    \Slim\Slim::registerAutoloader();
    
    // create the slim router
    $app = new \Slim\Slim(
        array(
            'debug' => true
        )
    );
    
	/* telemetry functions */
    $app->post('/telemetry',
			function() {
				$telemetry = new Telemetry();
				$telemetry->handle_post();
			});
    
    /* foody main api */
    $app->get('/api/v1/categories/:key',
			function($key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_categories();
			});
	
    $app->get('/api/v1/items/:key/',
			function($key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_items();
			});
	
	$app->get('/api/v1/regions/:key/',
				function($key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_regions();
			});
	
	$app->get('/api/v1/items/prices/:category/:key',
			function($category, $key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_category_prices($category);
			});

	$app->get('/api/v1/items/prices/:region/:key',
			function($category, $key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_region_prices($region);
			});

	$app->get('/api/v1/items/prices/:item/:key',
			function($item, $key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_item_prices(item, -1);
			});
	
	$app->get('/api/v1/items/prices/:item/:category/:key',
			function($item, $category, $key) {
				$foodyApi = new Foody($key);
				$foodyApi->get_item_prices($item, $category);
			});
	
	/* run the slim app */
    $app->run(); 
?>
