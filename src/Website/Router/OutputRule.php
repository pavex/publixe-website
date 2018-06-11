<?php

	namespace Publixe\Website\Router;
	use Publixe;
	use Publixe\Website\ActionHandler;
	use Publixe\Url;


/**
 * Output router rule
 *
 * @author	Pavel Machбиek <pavex@ines.cz>
 */
	class OutputRule implements IOutputRule
	{





/**
 * @param string
 * @param string|Publixe\Url|callable
 */
		public function __construct($pattern, $url)
		{
			$this -> pattern = $pattern;
			$this -> url = $url;
		}





/**
 * @param Publixe\Website\ActionHandler
 * @return Publixe\Url|NULL|FALSE
 */
		public function getUrl(ActionHandler $handler)
		{
			if (preg_match($this -> pattern, $handler -> presenter, $match)) {
				if (is_callable($this -> url)) {
					return call_user_func($this -> url, $this, $handler, $match);
				}
				return $this -> url;
			}
			return FALSE;
		}





	}


?>