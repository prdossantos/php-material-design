<?php
namespace PMD;
/**
* 
*/
class Template
{
	public $template_dir;
	public $component;
	public $name;
	public $template;
	public $file;
	public $twig;
	public $loader;
	public $config;

	function __construct($template_dir='',$config=array())
	{
		$this->template_dir = ($template_dir) ? $template_dir : 'src/PMD/Templates/Components';
		$this->config = ($config) ? array_unique(array_merge(array(
		    'cache' => 'src/PMD/Templates/Cache',
		),$config)) : array(
		    'cache' => false//'src/PMD/Templates/Cache',
		);
		$this->loader = new \Twig_Loader_Filesystem($this->template_dir);
		$this->twig = new \Twig_Environment($this->loader, $this->config);
		$escaper = new \Twig_Extension_Escaper('html');
		$this->twig->addExtension($escaper);
	}

	public function set($component,$name,$template,$create_dir=false)
	{
		$this->component = $component; 
		$this->name = $name; 
		$this->template = $template; 

		$name = ($this->name) ? $name.'.html' : strtolower($this->component).'.html';
		$name = str_replace('.html.html', '.html', $name);

		$this->file = $this->component.'/'.$name;

		if( !is_dir($this->template_dir .'/'.$this->component) ) {
			if( !$create_dir )
				throw new \ErrorException("Directory {$component} not found", 1);

			mkdir($this->template_dir .'/'.$this->component,0777);
		}

		$handle = fopen($this->template_dir .'/'.$this->file, 'w');
		fwrite($handle, $tthis->template);
		fclose($handle);

		return $this->template;
	}

	public function get($component,$args=array())
	{
		$this->component = $component; 
		$this->name = (isset($args['pmd_component_type'])) ? $args['pmd_component_type'] : 'default';
		
		$name = ($this->name) ? $this->name.'.html' : strtolower($this->component).'.html';
		$name = str_replace('.html.html', '.html', $name);

		$this->file = $this->component.'/'.$name;

		if( !is_file( $this->template_dir .'/'. $this->file ) ) { 
			throw new \ErrorException("Template {$this->file} not found", 1);
		}
		return $this->twig->render($this->file,$args);
	}

	public function cleanOut($str)
	{
		$str = str_replace(array('&lt;','&gt;'),array('<','>'),$str);

		return $str;
	}
}