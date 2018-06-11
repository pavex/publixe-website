<?php

	namespace Publixe\Website;
	use Publixe;
	use Publixe\Website\Control;
	use Publixe\Website\Exception\InvalidPresenterException;


/**
 * Presenter factory
 *
 * @author	Pavel Macháček <pavex@ines.cz>
 */
	final class PresenterFactory //implements IControlInjector
	{


/** @var callable */
		public $callback;

/** @var Publixe\Website\Control */
		public $control;





/**
 * @param callable	function (string $class): IPresenter
 */	
		public function __construct(callable $callback = NULL)
		{
			$this -> callback = $callback ?: function($class) {return new $class;};
		}





/**
 * @param Publixe\Website\Control
 */
		public function injectControl(Publixe\Website\Control $control)
		{
			$this -> control = $control;
		}





/**
 * @param string
 * @return Publixe\Website\Presenter
 */	
		public function createPresenter($name, array $args = [])
		{
			$presenter = call_user_func($this -> callback, $name);
			if (!$presenter instanceof Publixe\Website\Presenter) {
				throw new InvalidPresenterException();
			}
// Inject agruments
			$vars = array_keys(get_object_vars($presenter));
			foreach ($args as $name => $value) {
				if (in_array($name, $vars)) {
					$presenter -> {$name} = $value;
				}
			}
// Inject control
			if ($this -> control) {
				$presenter -> injectControl($this -> control);
			}
			return $presenter;
		}





	}
