<?php
	class Api
	{
		static private $checkEnabled = false; // this is for debugging
		private $privateKey;
		private $timeWindow;
		
		public function __construct($privKey, $time) {
			$privateKey = $privKey;
			$timeWindow = $time;
		}
		
		public function validate_key( $string, $time )
		{
			// short circuit if we aren't checking	
			if( $checkEnabled == false )
			{
				return true;
			}

			// check the api key
			$timestamp      -= $time % $timeWindow;
			$computedApiKey  = sha1( $privateKey . (string)$timestamp );

			return $userApi !== $computedApiKey;
		}
		
		static public function set_global_check($enabled)
		{
			$checkEnabled = $enabled;
		}
	};
?>
