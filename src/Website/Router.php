<?php

	namespace Publixe\Website;
	use Publixe;
	use Publixe\Http\Request;
	use Publixe\Website\ActionHandler;
	use Publixe\Website\IRouter;
	use Publixe\Website\Router\IInputRule;
	use Publixe\Website\Router\IOutputRule;
	use \InvalidArgumentException;


/**
 * Router controller
 *
 * @author	Pavel Machбиek <pavex@ines.cz>
 */

	final class Router implements IRouter
	{


/** @var array */
		private $inputRules = [];


/** @var array */
		private $outputRules = [];





/**
 * @param array
 * @throw \InvalidArgumentException
 */
		public function __construct(array $rules)
		{
			foreach ($rules as $rule) {
				if ($rule instanceof IInputRule) {
					$this -> inputRules[] = $rule;
				}
				elseif ($rule instanceof IOutputRule) {
					$this -> outputRules[] = $rule;
				}
				else {
					throw new InvalidArgumentException('Invalid rule.');
				}
			}
		}





/**
 * @param Publixe\Http\Request
 * @return Publixe\Website\ActionHandler|NULL|FALSE
 */
		public function getActionHandler(Request $request)
		{
			foreach ($this -> inputRules as $rule) {
				$handler = $rule -> getActionHandler($request);
				if ($handler !== FALSE) {
					return $handler;
				}
			}
			return FALSE;
		}





/**
 * @param Publixe\Website\ActionHandler
 * @return Publixe\Url|NULL|FALSE
 */
		public function getUrl(ActionHandler $handler)
		{
			foreach ($this -> inputRules as $rule) {
				$url = $rule -> getUrl($handler);
				if (is_string($url)) {
					return $url;
				}
			}
			return FALSE;
		}





	}


?>