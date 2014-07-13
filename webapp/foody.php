<?php
	/*
	 foody.php - public api for foody web app
	 Michael A Bosse' (metiscus@gmail.com)
	*/
	
	require_once('Slim/Slim.php');
	require_once('config.php');
	require_once('api.php');
	
    /*  foody data requests are in http get format
		http://baseurl.com/api
		Api calls:
			/api/v1/categories/key/(keyhere)/
			/api/v1/items/key/(keyhere)/
			/api/v1/prices/key/(keyhere)
				.../category/{1,2,3,4,5}/		- gets prices for all items in a category
				.../itemid/{all valid ids}/		- gets price for a single item
    */
	class Foody
	{
		private $hostname = "localhost";
		private $username = "telemetry";
		private $password = "35b3rVF2Gl";
		private $schema   = "foody_telemetry";
		private $authenticated = false;

		public function __construct($key)
		{
			// perform authentication
			$api = new Api(Config.foodyApiPrivate, Config.foodyApiWindow);
			$authenticated = $api.validate_key($key, $_SERVER['REQUEST_TIME']);
		}
		
		private function open_database()
		{
			$mysqli = new mysqli($hostname, $username, $password, $schema);
			$mysqli->set_charset("UTF8");
			return $mysqli;
		}
		
		// Really important: Never, ever, put user content into this function
		private function process_static_query_get($queryString)
		{
			$status  = 'REQUEST_FAILED';
			$message = '';
			$data    = array();
			
			if($authenticated)
			{
				try {
					$db = open_database();
					$result = $db->query($queryString);
					
					$status = 'REQUEST_SUCCEEDED';
					while($row = $result->fetch_object()) {
						$tempArray = $row;
						array_push($data, $tempArray);
					}
				}
				catch( Exception $e)
				{
					$message = 'A database exception occurred while processing your request.';
				}
			}
			else{
				$message = 'Bad API Key presented.';
			}
			
			// send response
			$response            = array();
			$response['status']  = $status;
			$response['message'] = $message;
			$response['data']    = $data;
			
			return json_encode($response);
		}
		
		public function get_categories()
		{
			return process_static_query_get('select id, cat_desc, int_cat_desc from fdy_food_categories');
		}
		
		public function get_items()
		{
			return process_static_query_get('select id, category, extern_id, item_desc, int_item_desc from fdy_food_items');
		}
		
		public function get_regions()
		{
			return process_static_query_get('select id, reg_desc, int_reg_desc from fdy_regions');
		}
		
		public function get_category_prices($category)
		{
			$status  = 'REQUEST_FAILED';
			$message = '';
			$data    = array();
			
			if($authenticated)
			{
				try {
					$db = open_database();

					$stmt = $mysqli->prepare(
						"SELECT fdy_item_prices.*, fdy_food_items.id, fdy_food_items.category " .
						"	FROM fdy_item_prices INNER JOIN fdy_regions " .
						"		ON fdy_item_prices.item_id = fdy_food_items.id " .
						"	WHERE fdy_food_items.category=?"
					);
					$stmt->bind_param("i", $category);
					$stmt->execute();
				
					$result = $db->query('');
					
					$status = 'REQUEST_SUCCEEDED';
					while($row = $result->fetch_object()) {
						$tempArray = $row;
						array_push($data, $tempArray);
					}
				}
				catch( Exception $e)
				{
					$message = 'A database exception occurred while processing your request.';
				}
			}
			else{
				$message = 'Bad API Key presented.';
			}
			
			// send response
			$response            = array();
			$response['status']  = $status;
			$response['message'] = $message;
			$response['data']    = $data;
			
			return json_encode($response);
		}
		
		public function get_region_prices($region)
		{
			$status  = 'REQUEST_FAILED';
			$message = '';
			$data    = array();
			
			if($authenticated)
			{
				try {
					$db = open_database();
					
					$stmt = $mysqli->prepare(
						"SELECT * " .
						"	FROM fdy_item_prices " .
						"	WHERE region_id=?"
					);
					$stmt->bind_param("i", $region);
					$stmt->execute();
				
					$result = $db->query('');
					
					$status = 'REQUEST_SUCCEEDED';
					while($row = $result->fetch_object()) {
						$tempArray = $row;
						array_push($data, $tempArray);
					}
				}
				catch( Exception $e)
				{
					$message = 'A database exception occurred while processing your request.';
				}
			}
			else{
				$message = 'Bad API Key presented.';
			}
			
			// send response
			$response            = array();
			$response['status']  = $status;
			$response['message'] = $message;
			$response['data']    = $data;
			
			return json_encode($response);
		}
		
		public function get_item_prices($item, $category)
		{
			$status  = 'REQUEST_FAILED';
			$message = '';
			$data    = array();
			
			if( $category == -1 )
			{
				$category = "*";
			}
			
			if($authenticated)
			{
				try {
					$db = open_database();

					$stmt = $mysqli->prepare(
						"SELECT fdy_item_prices.*, fdy_food_items.id, fdy_food_items.category " .
						"	FROM fdy_item_prices INNER JOIN fdy_food_items " .
						"		ON fdy_item_prices.item_id = fdy_food_items.id " .
						"	WHERE fdy_item_prices.item_id=? AND fdy_food_items.category=?"
					);
					$stmt->bind_param("is", $item, $category);
					$stmt->execute();
				
					$result = $db->query('');
					
					$status = 'REQUEST_SUCCEEDED';
					while($row = $result->fetch_object()) {
						$tempArray = $row;
						array_push($data, $tempArray);
					}
				}
				catch( Exception $e)
				{
					$message = 'A database exception occurred while processing your request.';
				}
			}
			else{
				$message = 'Bad API Key presented.';
			}
			
			// send response
			$response            = array();
			$response['status']  = $status;
			$response['message'] = $message;
			$response['data']    = $data;
			
			return json_encode($response);
		}
	};
?>
