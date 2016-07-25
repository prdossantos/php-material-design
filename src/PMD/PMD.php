<?php
namespace PMD;

use PMD\Template;
use PHPLJ\Dom;
use PMD\Components\Cards;
use PMD\Components\Grid;

class PMD {

	private static $instance;
	private static $config;
	private static $setContainer = array();
	private static $html;
	private static $component;
	private static $name;

	private static function getInstance()
	{
		return !self::$instance ? new PMD : self::$instance;
	}

	/**
	 * Método de entrada na lib \Dom
	 * @param  string $html html que irá sera manipulado
	 * @return instance     \Dom
	 */
	public static function find($el)
	{
		$dom = new Dom(self::render(self::$component,self::$name,self::$setContainer,self::$config));
		return $dom->find($el);
	}

	public static function setConfig($arg1,$arg2='')
	{

		if ( !$arg1 ) throw new \ErrorException("Argument 1 is required ", 1);

		if( is_array( $arg1 ) ) {
			foreach ($arg1 as $key => $value) {
				self::$config[$key] = $value;
			}

			return self::getInstance();
		} 

		self::$config[$arg1] = $arg2;

		return self::getInstance();
	}

	public static function getConfig($arg1='')
	{
		if( $arg1 ) {
			return isset(self::$config[$arg1]) ? self::$config[$arg1] : null;
		}

		return self::$config;
	}

	public static function render($component,$name='default',$args=array(),$config=array())
	{
		if(!$name) $name = 'default';
		if(is_array($name)) { $args = $name; $name = 'default'; }

		$template = new Template((self::getConfig('template_dir') ? self::getConfig('template_dir') : ''),$config);
		return $template->get($component,$name,$args);
	}

	public static function prepare($component,$name='default',$config=array())
	{
		self::$component = $component;
		self::$name = $name;
		self::$config = $config;

		return self::getInstance();
	}

	public function set($el,$val)
	{
		if( !$el ) throw new \ErrorException("Element {$el} invalid", 1);
		
		self::$setContainer[$el] = $val;

		return self::getInstance();
	}

	public function get()
	{
		return self::render(self::$component,self::$name,self::$setContainer,self::$config);
	}

	/**
	 * Retorno das funções de componentes
	 * Ex.:
	 * -----
	 * PMD::card()
	 * ->add('button',['name'=>'asdf'])
	 * ->add('title','asdf')
	 * -----
	 * $grid = PMD::grid(3)
	 * ->add('Cards', function($card){
	 * 		$card->add('button')
	 * })
	 * 
	 * 
	 */
	public static function cards($args='') { return new Cards($args); }
	public static function grid($args=0) { return new Grid($args); }

}
