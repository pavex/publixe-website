<?php

	namespace Publixe\Http\Exception;
	use Publixe;
	use Publixe\Http\StatusCode;


/**
 */
	class InternalServerErrorException extends AbstractException
		implements IException
	{



/**
 * @param string
 * @param int
 */
		public function __construct($message = '', $code = 0)
		{
			parent::__construct($message, $code);
			$this -> setStatusCode(StatusCode::INTERNAL_SERVER_ERROR);
		}


	}

?>