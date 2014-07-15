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
    

    // Main API calls
    $app->group('/foody', function () use ($app) {
	
	$app->group('/api_v1', function () use ($app) {
	    
	    // Telemetry api calls
	    $app->post('/telemetry', function() {
		$telemetry = new Telemetry();
		$telemetry->handle_post();
	    });
	    
	    // Static data calls
	    $app->group('/static-data', function () use ($app) {
		// categories
		$app->get('/categories/:api/:key', function($api, $key) {
		    $foodyApi = new Foody($key);
		    echo $foodyApi->get_categories();
		});
	    
		$app->get('/items/:api/:key',  function($api, $key) {
		    $foodyApi = new Foody($key);
		    echo $foodyApi->get_items();
		});
	    
		$app->get('/regions/:api/:key', function($api, $key) {
		    $foodyApi = new Foody($key);
		    echo $foodyApi->get_regions();
		});
	    });
	    
	    // price lookups
	    $app->get('/prices/:api/:key', function($api, $key) {

		$foodyApi = new Foody($key);
		$region = $category = $item = '';
		
		if( isset($_GET['region']) )
		{
		    $region = $_GET['region']; 
		}
		
		if( isset($_GET['category']) )
		{
		    $category = $_GET['category'];
		}
		
		if( isset($_GET['item']) )
		{
		    $item = $_GET['item'];    
		}
		
		echo $foodyApi->get_prices($region, $category, $item);
	    });
	});
    });

    /* run the slim app */
    $app->run();
?>
