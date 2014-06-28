<?php
	$gApiCheckEnabled = false;
	$gApiPrivate      = 'DerpS@uC3';
	$gApiWindow       = 120;
	
	function handlePost()
	{
		// get the request
		$json = file_get_contents('php://input');
		$obj  = json_decode($json, true);
		if( isset($obj) && isset($obj['api']) && validateApi($obj['api'], $_SERVER['REQUEST_TIME']) )
		{
			if( !isset($obj['data']) )
			{
				return false;
			}

			// process data points
			return storeTransaction($obj['data']); 
		}
		else
		{
			return false;
		}
	}

	function handleGet()
	{

	
	}

	function handleRequest()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			return handlePost();
		}
		else if($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			return handleGet();
		}

		return 1;
	}


	function validateApi ( $userApi, $timestamp )
	{
		global $gApiCheckEnabled, $gApiPrivate, $gApiWindow;

		// short circuit if we aren't checking	
		if( $gApiCheckEnabled == false )
		{
			return true;
		}

		// check the api key
		$timestamp      -= $timestamp % $gApiWindow;
		$computedApiKey  = sha1( $gApiPrivate . (string)$timestamp );
	
		return $userApi !== $computedApiKey;
	}

	function storeTransaction( $data )
	{
		$mysqli = new mysqli("localhost", "telemetry", "35b3rVF2Gl", "foody_telemetry");
		$mysqli->set_charset("UTF8");
		
		if(!isset($data['uid']))
		{
			return false;
		}

		// insert the transaction record
		$stmt = $mysqli->prepare("INSERT INTO tel_trans(uid) VALUES( ? )");
		$stmt->bind_param("s", $data['uid']);
		$stmt->execute();
		$transId = $stmt->insert_id;

		// insert the transaction data
		$stmt = $mysqli->prepare("INSERT INTO tel_trans_data(trans, tkey, tvalue) VALUES( ?, ?, ? )");
		foreach( $data as $key => $value )
		{
			$stmt->bind_param("iis", $transId, $key, $value);
			$stmt->execute();
		}
		$stmt->close();
	
		return true;
	}

	if( !handleRequest() )
	{
		header("HTTP/1.0 500 Internal Server Error");
	}

?>
