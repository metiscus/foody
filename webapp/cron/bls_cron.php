<?php

// region codes
$regions = array("0000", "0100", "0200", "0300", "0400");

// read the target file and parse the csv
$target_ids = array_map('str_getcsv', file('target.csv'));

// 
$bls_url = "http://api.bls.gov/publicAPI/v1/timeseries/data/APU";

print_r($regions);

// for each region, get the data
foreach($regions as $region)
{
	// make the region directory
	mkdir("data/" . $region);

	echo "Working on region number: $region\n";

	// get the items
	foreach($target_ids as $target_id)
	{
		$request = $bls_url . $region . $target_id[0];
		$response = http_get( $request );
		
		file_put_contents( "data/" . (string)$region . "/" . $target_id[0], (string)$response );
	}
}

?>
