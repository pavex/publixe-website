<?php

	namespace Publixe\Website;
	use Publixe;


/**
 * Presener action hanler
 *
 * @author	Pavel Macháček <pavex@ines.cz>
 */
	final class ActionHandler
	{


//
		const EXECUTE = 'execute';


/** @var string */
		public $presenter;

/** @var string */
		public $action;

/** @var Array */
		public $args = [];





/**
 * @param string
 * @param string=
 * @param Array=
 */	
		public function __construct($presenter, $action = NULL, $args = [])
		{
			$this -> presenter = $presenter;
			$this -> action = $action ?: self::EXECUTE;
			$this -> args = $args;
		}





/**
 * @param string
 * @param string=
 * @param Array=
 * @return Publixe\Website\Handle
 */	
		public static function create($presenter, $action = NULL, $args = [])
		{
			return new self($presenter, $action, $args);
		}





	}
