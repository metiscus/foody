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
			echo "1";
			if( !isset($obj['data']) )
			{
				return false;
			}
			echo "2";

			// process data points
			return storeTransaction($obj['data']); 
		}
		else
		{
			echo "3";
			return false;
		}
	}

	function handleGet()
	{

	
	}

	function handleRequest()
	{
		echo $_SERVER['REQUEST_METHOD'];
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

	if( !handleRequest() )
	{
		http_response_code(500);
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
		echo "a";
		$mysqli = new mysqli("localhost", "telemetry", "35b3rVF2Gl", "foody_telemetry");
		echo "b";
		$mysqli->set_charset("UTF8");
		echo "c";
		
		if(!isset($data['uid']))
		{
			return false;
		}
		echo "d";

		// insert the transaction record
		$stmt = $mysqli->prepare("INSERT INTO tel_trans(uid) VALUES( ? )");
		echo $stmt->error;
		$stmt->bind_param("s", $data['uid']);
		echo $stmt->error;
		$stmt->execute();
		$stmt->close();
		echo $stmt->error;


		echo "b";
		$stmt = $mysqli->prepare("SELECT FROM tel_trans where uid=?");
		$stmt->bind_param("s", $data['uid']);
		$stmt->execute();
		$result = $stmt->get_result();
		print_r($result->fetch_field());
		$stmt->close();
	}


	//$result = $mysqli->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
	//$row = $result->fetch_assoc();
	//echo htmlentities($row['_message']);

	// parse the URI to get the parameters
	// form is /telemetry/api/<apikey>/uid/<uid>/key/<key>/value/<value>
	$argv = explode('/', $_SERVER['REQUEST_URI']);
	$argc = count($argv);
	
	// make sure this is a telemetry api call
	if( in_array( "telemetry", $argv ) == false )
	{
		exit(0);
	}

	if( $valueCount > 2 )
	{
	}
	
	for($idx=2; $idx<$valueCount; ++$idx)
	{
			
	}
	echo $values;

?>
