<?php
	require_once('config.php');
	
	// checks a user provided api key to see if it is valid
	// if the global check is disabled, it returns true
	function api_validate_userkey ( $userApi, $timestamp )
	{
		// begin: externals from config
        global $gApiCheckEnabled;
        global $gApiPrivate;
        global $gApiWindow;
        // end: externals from config

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
?>
