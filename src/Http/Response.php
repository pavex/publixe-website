<?php

	namespace Publixe\Http;
	use Publixe;
	use Publixe\Http\StatusCode;
	use \InvalidStateException;


/**
 * HTTP Response.
 *
 * @author	Pavel Machбиek <pavex@ines.cz>
 */
	class Response
	{


		const DEFAULT_CONTENT_TYPE = 'text/html';
		const DEFAULT_SERVER_PROTOCOL = 'HTTP/1.1';


/** @var boolean */
		private $sent = FALSE;

/** @var array */
		private $headers = array();

/** @var string */
		public $contents;

/** @var int */
		public $status = NULL;





/**
 * Set status code.
 * @param int
 */
		public function setStatusCode($status)
		{
			$this -> status = $status;
		}





/**
 * @param string
 * @param string
 */
		public function setHeader($name, $value)
		{
			if (!isset($this -> headers[$name])) {
				$this -> headers[$name] = $value;
			}
		}





/**
 * Set output content type.
 * @param string=
 * @param string=
 */
		public function setContentType($type = self::DEFAULT_CONTENT_TYPE, $charset = NULL)
		{
			$value = $type . ($charset ? ('; charset=' . $charset) : '');
			$this -> setHeader('Content-Type', $value);
		}





/**
 * Set output contents.
 * @param string
 * @param string=
 */
		public function setContents($contents, $content_type = self::DEFAULT_CONTENT_TYPE)
		{
			$this -> contents = $contents;
			$this -> setContentType($content_type);
		}





/**
 * Add redirect header into response
 * @param string|Publixe\Url
 * @param int=
 */
		public function redirect($url, $status = StatusCode::FOUND)
		{
			$this -> setHeader('Location', $url);
			$this -> status = $status;
			$this -> contents = NULL;
			$this -> send();
		}





/**
 * @return boolean
 */
		public function isRedirect()
		{
			return ceil($this -> status / 100) == 3;
		}





/**
 * Send response
 * @thorw \InvalidStateException
 */
		public function send()
		{
			if (!$this -> sent) {
				$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : self::DEFAULT_SERVER_PROTOCOL;
				$status = $this -> status ? $this -> status : StatusCode::OK;				
				header($protocol . ' ' . $status);
				foreach ($this -> headers as $name => $value) {
					header(sprintf("%s: %s", $name, $value));
				}
				print $this -> contents;
				return;
			}
			throw new InvalidStateException('Response already sent.');
		}





/**
 * Automatic send response in destructor
 */
		public function __destruct()
		{
			if (!$this -> sent) {
				$this -> send();
			}
		}





	}


?>