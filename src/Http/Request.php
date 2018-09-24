<?php

	namespace Publixe\Http;
	use Publixe\Url;
	use Publixe\UrlScript;


/**
 * HTTP Request.
 *
 * @author	Pavel Macháèek <pavex@ines.cz>
 */
	class Request
	{


/** @var Publixe\UrlScript */
		public $url;

/** @var string */
		public $method;

/** @var array */
		public $post;

/** @var array */
		public $files;

/** @var array */
		public $cookies;

/** @var array */
		public $headers;

/** @var string */
		public $remoteAddress;

/** @var string */
		public $remoteHost;

/** @var bool */
		public $indirect;





/**
 * @param Publixe\UrlScript
 * @param string
 */
		public function __construct(UrlScript $url, $method = NULL)
		{
			$this -> url = $url;
			$this -> method = strtoupper($method);
		}





/**
 * @param  string
 * @return bool
 */
		final public function isMethod($method)
		{
			return $this -> method == strtoupper($method);
		}





/**
 * @return bool
 */
		final public function isPost()
		{
			return $this -> isMethod('POST');
		}





/**
 * @return bool
 */
		final public function isSecured()
		{
			if ($this -> url instanceOf Url) {
				return $this -> url -> scheme === 'https';
			}
			return FALSE;
		}





/**
 * @param  string
 * @param  mixed=
 * @return mixed
 */
		final public function getHeader($header, $default = NULL)
		{
			if (isset($this -> headers[$header])) {
				return $this -> headers[$header];
			}
		}





/**
 * Return default accepted content type
 * @return string
 */
		final public function getContentType($default = 'text/html')
		{
var_dump($this -> getHeader('accept', FALSE));
var_dump($this -> getHeader('content-type', FALSE));

			if ($accept_string = $this -> getHeader('accept', FALSE)) {
				if (preg_match('/^([a-z0-9\/]*)(\,|$)/i', $accept_string, $match)) {
					return $match[1];
				}
			}
			elseif ($content_type_string = $this -> getHeader('content-type', FALSE)) {
				if (preg_match('/^([a-z0-9\/]*)(\,|$)/i', $content_type_string, $match)) {
					return $match[1];
				}
			}
			return $default;
		}





/**
 * @return mixed
 */
		final public function getRawPostData()
		{
			return file_get_contents("php://input");
		}





/**
 * @return bool
 */
		final public function isAjax()
		{
			return $this -> getHeader('x-requested-with') === 'XMLHttpRequest';
		}





/**
 * @return Array<string>
 */		
		private static function getRequestHeaders()
		{
			if (!function_exists('apache_request_headers')) {
				$headers = [];
				foreach ($_SERVER as $k => $v) {
					if (strncmp($k, 'HTTP_', 5) == 0) {
						$k = substr($k, 5);
					}
					elseif (strncmp($k, 'CONTENT_', 8)) {
						continue;
					}
					$headers[strtr($k, '_', '-')] = $v;
				}
				return $headers;
			}
			return apache_request_headers();
		}





/**
 * Build current request
 * @return Publixe\Http\Request
 */
		public static function create()
		{
			$request_uri_string = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
			$script_name = $_SERVER['SCRIPT_NAME'];
// Create url
			$url = new UrlScript($request_uri_string);
			$url -> scheme = !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
			$url -> host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : NULL;
			$url -> port = isset($_SERVER['SERVER_PORT']) ? intval($_SERVER['SERVER_PORT']) : NULL;
			$url -> user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
			$url -> password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
//
			$r = explode('/', $request_uri_string);
			$s = explode('/', $script_name);
			array_pop($s);

			$url -> scriptPath = '';
			foreach ($r as $key => $node) {
				if (isset($s[$key]) && $r[$key] == $s[$key]) {
					$url -> scriptPath .= $r[$key] . '/';
				}
				else continue;
			}
//
			$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : NULL;
// Create request
			$request = new self($url, $method);
			$request -> post = &$_POST;
			$request -> files = &$_FILES;
			$request -> cookies = &$_COOKIE;
			$request -> headers = array_change_key_case(self::getRequestHeaders(), CASE_LOWER);
			$request -> remoteAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : NULL;
			$request -> remoteHost = isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : NULL;
			$request -> indirect = isset($_SERVER['REDIRECT_STATUS']);
			return $request;
		}





	}


?>