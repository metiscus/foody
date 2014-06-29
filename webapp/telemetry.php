<?php
	require_once('Slim/Slim.php');
	require_once('config.php');
	require_once('api.php');
	
    /*  telemetry requests are in json format from POST in the following structure
        {
            'api' : sha1(private key + timestamp rounded to nearest 2 minutes),
            'uid' : sha1(phone hardware id),
            data {
                "key" : "value pairs",
                "key2" : "keys are integers and values are some data"
            }
        }
    */
    
	function telemetry_handle_post()
	{
		$app = \Slim\Slim::getInstance();
		$request = $app->request();
		$response = $app->response();
		$body = $request->getBody();
		$json = json_decode($body, true);

		// default the return status to a bad request    
	    $status = 400;

		if( isset($json) && isset($json['api']) && api_validate_userkey($json['api'], $_SERVER['REQUEST_TIME']) )
		{
			if( isset($json['data']) )
			{
				$status = telemetry_store_transaction($json['data']);
			}
		}
        $response->setStatus($status);
	}

	function telemetry_store_transaction( $data )
	{
		$mysqli = new mysqli("localhost", "telemetry", "35b3rVF2Gl", "foody_telemetry");
		$mysqli->set_charset("UTF8");
		
		if(isset($data['uid']) && count($data) > 1)
		{
    		// insert the transaction record
    		$stmt = $mysqli->prepare("INSERT INTO tel_trans(uid) VALUES( ? )");
    		$stmt->bind_param("s", $data['uid']);
    		$stmt->execute();
    		$transId = $stmt->insert_id;

    		// insert the transaction data
    		$stmt = $mysqli->prepare("INSERT INTO tel_trans_data(trans, tkey, tvalue) VALUES( ?, ?, ? )");
    		foreach( $data as $key => $value )
    		{
    			if( $key != 'uid' )
				{
					$stmt->bind_param("iis", $transId, $key, $value);
					$stmt->execute();
				}
    		}
    		$stmt->close();
            
            return 200;
        }	
		return 400;
	}
?>
