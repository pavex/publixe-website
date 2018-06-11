<?php

	namespace Publixe\Http;
	use Publixe;


/**
 */
	class StatusCode
	{
		const OK = 200;
		const CREATED = 201;
		const NO_CONTENT = 204;
		const RESET_CONTENT = 205;
		const PARTIAL_CONTENT = 206;
		const MOVED_PERMANENTLY = 301;
		const FOUND = 302;
		const NOT_MODIFIED = 304;
		const TEMPORARY_REDIRECT = 307;
		const BAD_REQUEST = 400;
		const UNAUTHORIZED = 401;
		const FORBIDDEN = 403;
		const NOT_FOUND = 404;
		const METHOD_NOT_ALLOWED = 405;
		const NOT_ACCEPTABLE = 406;
		const REQUEST_TIMEOUT = 408;
		const CONFLICT = 409;
		const UNSUPPORTED_MEDIA_TYPE = 415;
		const UNSUPPORTABLE_ENTITY = 422;
		const INTERNAL_SERVER_ERROR = 500;
	}

?>