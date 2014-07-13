<?php
	/*
	 bls_cron.php - script to fetch price information from the bls public API
	 Michael A Bosse' (metiscus@gmail.com)
	*/
	
	// region codes
	$regions = array("0000", "0100", "0200", "0300", "0400");
	
	// read the target file and parse the csv
	$target_ids = array_map('str_getcsv', file('target.csv'));
	
	// 
	$bls_url = "http://api.bls.gov/publicAPI/v1/timeseries/data/APU";
	
	// open the database handle
	$mysqli = new mysqli("localhost", "foody", "hGNhpbLKPFf8", "foody_data");
	if(!isset($mysqli))
	{
		echo "Database error. Check database info.\n";
		exit(1);
	}
	$mysqli->set_charset("UTF8");
	
	$errorCount = 0;
	
	$regionCounter = 0;
	
	// for each region, get the data
	foreach($regions as $region)
	{
		echo "Working on region number: $region\n";
		++$regionCounter;
		
		// get the items
		foreach($target_ids as $target_id)
		{
			$request = $bls_url . $region . $target_id[0];
			$response = http_get( $request );
			
			// strip the headers from the body
			list($header, $body) = preg_split("/\R\R/", $response, 2);
			
			// parse the body of the response
			$json = json_decode($body, true);
			
			// if there was an error, report it
			if( $json['status'] !== 'REQUEST_SUCCEEDED' )
			{
				print("Request for $target_id in region $region returned an error: " . $json['message'] . ".\n");
				++$errorCount;
				continue;
			}
			
			//print_r($json);
			
			// results are stored in the result
			$results = $json['Results'];
			if(!isset( $results['series']['0']['data']['0'] ))
			{
				print_r("Exception fetching data: $response\n");
				print_r("Json: $json\n");	
			}
			
			$data    = $results['series']['0']['data']['0'];
			
			// look up the item id
			$target_id_str = (string)$target_id[0];
			if( ! ($idlookup = $mysqli->query("select id from fdy_food_items where extern_id='" . $target_id_str . "'")) )
			{
				print_r($idlookup);
				printf("failed to look up item $target_id[0]\n");
			}
	
			$idresult = $idlookup->fetch_assoc();
			
			// for the returned result, upsert in the table
			$stmt = $mysqli->prepare(
				"INSERT INTO fdy_item_prices(item_id, region_id, price, updated, source)" .
				"VALUES( ?, ?, ?, CURDATE(), ? )" .
				"ON DUPLICATE KEY UPDATE price=VALUES(price), region_id=VALUES(region_id), updated=VALUES(updated), source=VALUES(source)"
			);
			
			$sourceId = 1;
			if( isset($idresult['id']) )
			{
				$stmt->bind_param("iidi", $idresult['id'], $regionCounter, $data['value'], $sourceId);
				$stmt->execute();
			}
		}
	}

?>
