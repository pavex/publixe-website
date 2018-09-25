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
		protected $title = NULL;

/** @var string */
		protected $website_base_url = NULL;

/** @var string */
		private $website_css_files = [];

/** @var Publixe\Html\Element */
		protected $headElement;

/** @var Publixe\Html\Element */
		protected $bodyElement;





/**
 * @param string
 */
		protected function setLanguage($lang)
		{
			$this -> lang = $lang;
		}
		
		

		protected function setTitle($title)
		{
			$this -> title = $title;
		}
		
		
		
		
		
		private $body_css_class_list = [];
		
		
		
		protected function insertBodyCssClass($css_class)
		{
			if (!in_array($css_class, $this -> body_css_class_list)) {
				$this -> body_css_class_list[] = $css_class;
			}
		}
		
		
		protected function getBodyCssClass()
		{
			return implode(' ', $this -> body_css_class_list);
		}


		protected function renderBodyCssClass()
		{
			echo !empty($this -> body_css_class_list) ? sprintf(" class=\"%s\"", $this -> getBodyCssClass()) : NULL;
		}





/**
 * @type Array<Array>
 */
		private $javascript_list = [];





/**
 * @param string
 * @param boolean
 */
		protected function requireJavascript($src, $async)
		{
			if (!isset($this -> javascript_list[$src])) {
				$this -> javascript_list[$src] = [$async]; 
			}
		}





/**
 * @param string
 * @param string=
 */
		protected function js($href, $async = FALSE)
		{
			$this -> requireJavascript($href, $async);
		}





/**
 * @return string
 */
		protected function renderJavascripts()
		{
			$html = "";
			foreach ($this -> javascript_list as $src => $javascript) {
				list($async) = $javascript;
				$html .= sprintf("<script type=\"text/javascript\" src=\"%s\"%s></script>", $src, $async ? " async" : "");
			}
			echo $html;
		}





/**
 * @type Array<Array>
 */
		private $stylesheet_list = [];





/**
 * @param string
 * @param string
 */
		protected function requireStylesheet($href, $media)
		{
			if (!isset($this -> stylesheet_list[$href])) {
				$this -> stylesheet_list[$href] = [$media];
			}
		}





/**
 * @param string
 * @param string=
 */
		protected function css($href, $media = 'screen')
		{
			$this -> requireStylesheet($href, $media);
		}





/**
 * @return string
 */
		protected function renderStylesheets()
		{
//var_dump($this -> stylesheet_list);
			$html = "";
			foreach ($this -> stylesheet_list as $href => $stylesheet) {
				list($media) = $stylesheet;
				
				$html .= sprintf("<link rel=\"stylesheet\" href=\"%s\" media=\"%s\" />", $href, $media);
			}
			echo $html;
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
			$this -> getControl() -> getHttpResponse() -> setContentType('text/html');
			$content = parent::render();
			return $content;
		}
			

	}

?>