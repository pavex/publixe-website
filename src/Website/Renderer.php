<?php

	namespace Publixe\Website;
	use Publixe;
	use Publixe\Website\ITemplate;
//	use \InvalidArgumentException;
	use \ReflectionClass;


/**
 * Renderer
 *
 * @author	Pavel Macháèek <pavex@ines.cz>
 */
	abstract class Renderer
	{

/** @var string */
		private $contents = NULL;





/**
 * Get existing filename of template
 * @param ReflectionClass
 * @return string|NULL
 */
		private function getTemplateFilename(ReflectionClass $reflection)
		{
			$filename = $reflection -> getFileName();
			$filename = preg_replace('/([a-z]+\.[a-z]+)$/i', 'template/\\1', $filename);
			return file_exists($filename) ? $filename : NULL;
		}





/**
 * Include and process template.
 * @param  string  template filename to include
 * @return string  the return value of the evaluated code
 */
		protected function getTemplateContents($filename)
		{
			ob_start();
			include $filename;
			return ob_get_clean();
		}





/**
 * @return string
 */
		protected function getContents()
		{
			return $this -> contents;
		}





/**
 * @return string
 */
		protected function renderContents()
		{
			echo $this -> getContents();
		}





/**
 * Presenter templates renderer
 * @return string
 */
		public function render()
		{
			$reflection = new ReflectionClass($this);
			do {
				if ($reflection && $filename = $this -> getTemplateFilename($reflection)) {
					$this -> contents = $this -> getTemplateContents($filename);
					$reflection = $reflection -> getParentClass();
				}
			}
			while ($filename);
			return $this -> contents;
		}





	}
