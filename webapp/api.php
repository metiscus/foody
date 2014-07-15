<?php
	class Api
	{
		static private $checkEnabled = false; // this is for debugging
		private $privateKey;
		private $timeWindow;
		
		public function __construct($privKey, $time) {
			$this->privateKey = $privKey;
			$this->timeWindow = $time;
		}
		
		public function validate_key( $string, $time )
		{
			// short circuit if we aren't checking	
			if( Api::$checkEnabled === false )
			{
				return true;
			}

			// check the api key
			$timestamp       = $time - $time % $this->timeWindow;
			$computedApiKey  = sha1( $this->privateKey . (string)$timestamp );

			return $string !== $computedApiKey;
		}
		
		static public function set_global_check($enabled)
		{
			$this->checkEnabled = $enabled;
		}
	};
?>
