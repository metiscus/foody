<?php
    /*
     foody.php - public api for foody web app
     Michael A Bosse' (metiscus@gmail.com)
    */
    
    require_once('Slim/Slim.php');
    require_once('config.php');
    require_once('api.php');
    
    class Foody
    {
        private $hostname = "localhost";
        private $username = "foody";
        private $password = "hGNhpbLKPFf8";
        private $schema   = "foody_data";
        private $authenticated = false;

        public function __construct($key)
        {
            // perform authentication
            $api = new Api(Config::$foodyApiPrivate, Config::$foodyApiWindow);
            $this->authenticated = $api->validate_key($key, $_SERVER['REQUEST_TIME']);
        }
        
        private function open_database()
        {
            $mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->schema);
            $mysqli->set_charset("UTF8");
            return $mysqli;
        }
        
        // Really important: Never, ever, put user content into this function
        private function process_static_query_get($queryString)
        {
            $status  = 'REQUEST_FAILED';
            $message = '';
            $data    = array();
            
            if($this->authenticated)
            {
                try {
                    $db = $this->open_database();
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
            return $this->process_static_query_get('select id, cat_desc, int_cat_desc from fdy_food_categories');
        }
        
        public function get_items()
        {
            return $this->process_static_query_get('select id, category, extern_id, item_desc, int_item_desc from fdy_food_items');
        }
        
        public function get_regions()
        {
            return $this->process_static_query_get('select id, reg_desc, int_reg_descc from fdy_regions');
        }
        
        public function get_prices($region, $category, $item)
        {
            $status  = 'REQUEST_FAILED';
            $message = '';
            $data    = array();
            
	    if($this->authenticated)
            {
		$db = null;
		try {
		    $db = $this->open_database();

		    // build the where clause based on the parameters
		    $where = '';
		    $bindParams = array();
		    
		    // Region based searches
		    if( !empty($region) )
		    {
			$param = array();
			$param['type']  = 'i';
			$param['value'] = $region;
			array_push($bindParams, $param);
			
			if( !empty($where) )
			{
			    $where = $where . " AND ";
			}
			else{
			    $where = " WHERE ";
			}
			
			$where = $where . "fdy_item_prices.region_id=?";
		    }
		    
		    // Category based searches
		    if( !empty($category) )
		    {
			$param = array();
			$param['type']  = 'i';
			$param['value'] = $category;
			array_push($bindParams, $param);
			
			if( !empty($where) )
			{
			    $where = $where . " AND ";
			}
			else{
			    $where = " WHERE ";
			}
			
			$where = $where . " fdy_food_items.category=?";    
		    }		    

		    // Item based searches
		    if( !empty($item) )
		    {
			$param = array();
			$param['type']  = 'i';
			$param['value'] = $item;
			array_push($bindParams, $param);
			
			if( !empty($where) )
			{
			    $where = $where . " AND ";
			}
			else{
			    $where = " WHERE ";
			}
			
			$where = $where . " fdy_item_prices.item_id=?";    
		    }	
    
		    $queryStr = "SELECT fdy_item_prices.item_id, fdy_item_prices.region_id, " .
			" 	fdy_item_prices.price, fdy_item_prices.updated, " .
			" 	fdy_food_items.category " .
                        "   FROM fdy_item_prices INNER JOIN fdy_food_items " .
                        "       ON fdy_item_prices.item_id = fdy_food_items.id ";
    
		    // set up the query
		    if( empty($where) )
		    {
			return $this->process_static_query_get($queryStr);
		    }


		    $stmt = $db->prepare( $queryStr . $where );
		    
		    // bind parameters
		    if( count($bindParams) == 1 ) {
			$stmt->bind_param( $bindParams[0]['type'], $bindParams[0]['value']);
		    }
		    else if( count($bindParams) == 2 ) {
			$stmt->bind_param( $bindParams[0]['type'] . $bindParams[1]['type'],
			    $bindParams[0]['value'], $bindParams[1]['value']
			);
		    }
		    else if( count($bindParams) == 3 ) {
			$stmt->bind_param( $bindParams[0]['type'] . $bindParams[1]['type'] . $bindParams[2]['type'],
			    $bindParams[0]['value'], $bindParams[1]['value'], $bindParams[2]['value']
			);
		    }		    
		    
		    $stmt->execute();
		    
                    $status = 'REQUEST_SUCCEEDED';

		    $stmt->bind_result($itemId, $regionId, $price, $updated, $category);

		    while($stmt->fetch())
		    {
			$row = array();
			$row['item']     = $itemId;
			$row['region']   = $regionId;
			$row['price']    = $price;
			$row['updated']  = $updated;
			$row['category'] = $category;
			
			array_push($data, $row);
		    }
                }
                catch( Exception $e) {
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
    }
?>
