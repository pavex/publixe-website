<?php

	namespace Publixe\Website\Router;
	use Publixe;
	use Publixe\Http\Request;
	use Publixe\Website\ActionHandler;


/**
 * Input router rule
 *
 * @author	Pavel Machбиek <pavex@ines.cz>
 */
	class InputRule implements IInputRule
	{





/**
 * @param string
 * @param string|callable
 * @param string=
 */
		public function __construct($pattern, $presenter, $action = NULL)
		{
			$this -> pattern = $pattern;
			$this -> presenter = $presenter;
			$this -> action = $action;
		}





/**
 * @param Publixe\Http\Request
 * @return Publixe\Website\ActionHandler|NULL|FALSE
 */
		public function getActionHandler(Request $request)
		{
			$url_string = $request -> url -> getRelativeUrl();
			if (preg_match($this -> pattern, $url_string, $match)) {
				if (is_callable($this -> presenter)) {
					return call_user_func($this -> presenter, $this, $request, $match);
				}
				return ActionHandler::create($this -> presenter, $this -> action,
					$request -> url -> getParams()
				);
			}
			return FALSE;
		}





	}


?>