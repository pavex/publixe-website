<?php

	namespace Publixe\Website;
	use Publixe;
	use Publixe\Http\Request;
	use Publixe\Http\Response;
	use Publixe\Website\PresenterFactory;
	use Publixe\Website\IRouter;
	use Publixe\Http\Exception\NotFoundException;
	use Publixe\Http\Exception\InternalServerErrorException;
	use Publixe\Http\Exception\IException;
	use \Exception;
	use \BadFunctionCallException;


/**
 * Application base controller.
 * @author	Pavex <pavex@ines.cz>
 */
	class Control
	{


/** @var Publixe\Website\PresenterFactory */
		private $presenterFactory;

/** @var Publixe\Website\Router */
		private $router;

/** @var Publixe\Http\Request */
		private $httpRequest;

/** @var Publixe\Http\Response */
		private $httpResponse;

/** @var array */
		private $args;

/** @var string */
		private $accepted_content_type;





/**
 * @param Publixe\Website\PresenterFactory
 * @param Publixe\Website\IRouter
 * @param Publixe\Http\Request=
 * @param Publixe\Http\Response=
 */
		public function __construct(PresenterFactory $presenterFactory, IRouter $router,
			Request $request = NULL, Response $response = NULL)
		{
			$this -> presenterFactory = $presenterFactory;
			$this -> presenterFactory -> injectControl($this);
			$this -> router = $router;
			$this -> httpRequest = $request !== NULL ? $request : Request::create();
			$this -> httpResponse = $response !== NULL ? $response : new Response();
		}





/**
 * @return Publixe\Http\Request
 */
		public function getHttpRequest()
		{
			return $this -> httpRequest;
		}





/**
 * @return Publixe\Http\Response
 */
		public function getHttpResponse()
		{
			return $this -> httpResponse;
		}





/**
 * Process website presenter life-cycle
 * @param Publixe\Website\ActionHandler
 */
		private function action(ActionHandler $handler)
		{
			try {
				$presenter = $this -> presenterFactory
					-> createPresenter($handler -> presenter, $handler -> args);
			}
			catch (\Exception $e) {
				throw new InternalServerErrorException($e -> getMessage());
			}

// Call action/execute
			if (!method_exists($presenter, $handler -> action)) {
				throw new BadFunctionCallException(sprintf("Can not call `%s`.", $handler -> action));
			}
			$presenter -> startup();
			call_user_func_array([$presenter, $handler -> action], []);
//
			$response = $this -> httpResponse;
			if (!$response -> isRedirect() && empty($response -> contents)) {
				$response -> contents = $presenter -> render();
			}
			unset($presenter);
		}





/**
 * @param Array
 * @param string
 * @param mixed=
 * @return mixed
 */
/*
		private function exceptArg(array &$args, $name, $default = NULL)
		{
			if (array_key_exists($name, $args)) {
				$val = $args[$name];
				unset($args[$name]);
				return $val;
			}
			return $default;
		}
*/





/**
 * @param Exception
 */
		private function throwException($e)
		{
			$response = $this -> httpResponse;
			if (defined('DEV')) {
				$response -> setHeader('X-Exception-Type', get_class($e));
				$response -> setHeader('X-Exception-Message', $e -> getMessage());
				$response -> setHeader('X-Exception-Code', $e -> getCode());
				$response -> setHeader('X-Exception-File', $e -> getFile());
				$response -> setHeader('X-Exception-Line', $e -> getLine());
			}
			$response -> status = $e instanceOf IException ? $e -> getStatusCode() : 500;
			$response -> send();
//
			if (defined('DEV')) {
				throw $e;
			}
		}





/**
 */
		public function run()
		{
			$time = -microtime(TRUE);
			try {
				$request = $this -> httpRequest;
				$this -> accepted_content_type = $request -> getContentType();
//
				$response = $this -> httpResponse;
				$response -> setContentType($this -> accepted_content_type);
//
				$handler = $this -> router -> getActionHandler($request);
//
				if ($handler !== NULL) {
					if (!$handler) {
						throw new NotFoundException("Empty presenter handler.");
					}
					$this -> action($handler);
				}
			}
			catch (Exception $e) {
				$this -> throwException($e);
			}
//
			$time += microtime(TRUE);
			$response -> setHeader('X-Generator-By', 'Publixe X3');
			$response -> setHeader('X-Generator-Timer', sprintf('%0.3f [s]', $time));
		}



	}
