<?php

	namespace Publixe\Http\Exception;
	use \Exception;


/**
 */
	abstract class AbstractException extends Exception
		implements IException
	{





/**
 * @private
 * @type int
 */
		private $status_code = NULL;





/**
 * @return int
 */		
		protected function setStatusCode($status_code)
		{
			$this -> status_code = $status_code;
		}





/**
 * @return int
 */		
		public function getStatusCode()
		{
			return $this -> status_code;
		}


	}

?>