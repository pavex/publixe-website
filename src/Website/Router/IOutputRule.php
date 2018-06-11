<?php

	namespace Publixe\Website\Router;
	use Publixe\Website\ActionHandler;


/**
 */
	interface IOutputRule
	{


/**
 * @param Publixe\Website\ActionHandler
 * @return Publixe\Url|NULL|FALSE
 */
		public function getUrl(ActionHandler $handler);


	}

?>