<?php

	namespace Publixe\Website;
	use Publixe;
	use \InvalidArgumentException;


/**
 * Renderer
 *
 * @author	Pavel Macháèek <pavex@ines.cz>
 */
	abstract class Renderer
	{


/** @var string */
		private $parent_template_name = NULL;

/** @var string */
		private $contents = NULL;





/**
 * Setup in template to define parent template if you neet it.
 * @param string
 */
		protected function setParentTemplate($name)
		{
			$this -> parent_template_name = $name;
		}





/**
 * @param string
 * @return string
 */
		private function getTemplateName(&$path)
		{
			$class_name = get_class($this);
			$class_name = strtr($class_name, '\\', '/');
			$path = preg_replace('/^(.*\/|).*$/i', '\\1template/', $class_name);
			return preg_replace('/^.*\/|([a-z]+)/i', '\\1', $class_name);
		}





/**
 * Get existing filename of template
 * @param string
 * @param string=
 * @return string|FALSE
 * @thorw \InvalidArgumentException
 */
		private function getTemplateFilename($name, $relative_path = '')
		{
			$filename = sprintf('%s%s.php', $relative_path, $name);
			if (!file_exists($filename)) {
				throw new \InvalidArgumentException(sprintf("Invalid template file `%s`.", $filename));
			}
			return $filename;
		}





/**
 * Include and process template.
 * @param  string  template filename to include
 * @return string  the return value of the evaluated code
 */
		protected function getTemplateContent($template_filename)
		{
			ob_start();
			include $template_filename;
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
 * Presenter templates renderer
 * @return string
 */
		public function render()
		{
			$this -> contents = NULL;
			$name = $this -> getTemplateName($path);
			do {
				$filename = $this -> getTemplateFilename($name, $path);
				$this -> parent_template_name = NULL;
				$this -> contents = $this -> getTemplateContent($filename);
				$name = $this -> parent_template_name;
			}
			while ($name);
			return $this -> contents;
		}





	}
