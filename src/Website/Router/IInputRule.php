<?php

	namespace Publixe\Website\Router;
	use Publixe\Http\Request;


/**
 */
	interface IInputRule
	{


/**
 * @param Publixe\Http\Request
 * @return Publixe\Website\ActionHandler|NULL|FALSE
 */
		public function getActionHandler(Request $request);


	}

?>