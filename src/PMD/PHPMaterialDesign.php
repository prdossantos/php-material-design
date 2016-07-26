<?php
namespace PMD;

use PMD\Template;
use PHPLJ\Dom;

class PHPMaterialDesign {

	private $config = array('template_dir'=>'src/PMD/Templates/Components');
	private $setContainer = array();
	private $html;
	private $component;
	private $name;

	public function __construct($component='',$args=array(),$config=array())
	{
		$args['pmd_component_type'] = (isset($args['pmd_component_type'])) ? $args['pmd_component_type'] : 'default';

		if($config) $this->config = $config;

		$this->component = $component;
		$this->setContainer = $args;
	}

	/**
	 * Método de entrada na lib \Dom
	 * @param  string $html html que irá sera manipulado
	 * @return instance     \Dom
	 */
	public function find($el)
	{
		$dom = new Dom($this->render($this->component,$this->setContainer,$this->config));
		return $dom->find($el);
	}

	public function setConfig($arg1,$arg2='')
	{

		if ( !$arg1 ) throw new \ErrorException("Argument 1 is required ", 1);

		if( is_array( $arg1 ) ) {
			foreach ($arg1 as $key => $value) {
				$this->config[$key] = $value;
			}

			return $this;
		} 

		$this->config[$arg1] = $arg2;

		return $this;
	}

	public function getConfig($arg1='')
	{
		if( $arg1 ) {
			return isset($this->config[$arg1]) ? $this->config[$arg1] : null;
		}

		return $this->config;
	}

	public function render($component='',$args=array(),$config=array())
	{
		$args['pmd_component_type'] = (isset($args['pmd_component_type'])) ? $args['pmd_component_type'] : 'default';

		$this->component = ($component) ? $component : $this->component;
		$this->setContainer = ($args) ? array_merge($args,$this->setContainer) : $this->setContainer;

		$template = new Template(($this->getConfig('template_dir') ? $this->getConfig('template_dir') : ''),$config);
		return $template->get($this->component,$this->setContainer);
	}

	public function prepare($component='',$args=array(),$config=array())
	{
		$args['pmd_component_type'] = (isset($args['pmd_component_type'])) ? $args['pmd_component_type'] : 'default';
		$this->component = ($component) ? $component : $this->component;
		$this->setContainer = ($args) ? array_merge($args,$this->setContainer) : $this->setContainer;

		return $this;
	}

	public function set($el,$val)
	{
		if( !$el ) throw new \ErrorException("Element {$el} invalid", 1);
		
		$this->setContainer[$el] = $val;

		return $this;
	}

	public function get()
	{
		return $this->render($this->component,$this->setContainer,$this->config);
	}

}
