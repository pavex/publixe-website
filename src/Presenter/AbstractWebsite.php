<?php

	namespace Publixe\Presenter;
	use Publixe;


/**
 * Abstract component for Wesite presenter.
 *
 * @author	Pavex <pavex@ines.cz>
 */
	abstract class AbstractWebsite extends Publixe\Website\Presenter
	{

/** @var string */
		protected $lang = 'en';

/** @var string */
		protected $charset = 'utf-8';

/** @var string */
		private $title = NULL;

/** @var string */
		private $website_base_url = NULL;

/** @var string */
		private $website_css_files = [];

/** @var Publixe\Html\Element */
		protected $headElement;

/** @var Publixe\Html\Element */
		protected $bodyElement;

		
		
		
/**
 * @param string
 */		
		protected function setTitle($title)
		{
			$this -> title = $title;
		}


		
		
		
/**
 * @param string
 */		
		protected function setBaseUrl($url = TRUE)
		{
			$this -> website_base_url = $url;
		}
		
		
		
		
/**
 * Render presenter output
 * @return string
 */
		public function render()
		{
			$content = parent::render();
			return $content;
		}
			

	}

?>