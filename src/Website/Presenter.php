<?php

	namespace Publixe\Website;
	use Publixe;
	use \LogicException;


/**
 * Presenter
 *
 * @author	Pavex <pavex@ines.cz>
 */
	abstract class Presenter extends Publixe\Website\Renderer
	{


/** @var Publixe\Control */
		private $control;





/**
 * @return Publixe\Website\Control
 */
		public function injectControl(Publixe\Website\Control $control)
		{
			$this -> control = $control;
		}





/**
 * @return Publixe\Website\Control
 * @throw LogicException
 */
		public function getControl()
		{
			if (!$this -> control) {
				throw new LogicException('Control not injected.');
			}
			return $this -> control;
		}





/**
 * Startup life-cycle
 */
		public function startup()
		{
		}





/**
 * Execute life-cycle
 */
		public function execute()
		{
		}





/**
 * Convert presenter name into string
 * @return string
 */
		public function __toString()
		{
			return get_class($this);
		}





	}
