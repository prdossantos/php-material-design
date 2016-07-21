<?php
namespace PMD;

use PMD\Template;
use PHPLJ\Dom;

class PMD {

	private static $instance;
	private static $config;
	private static $setContainer;
	private static $addToContainer;
	private static $component;
	private static $name;

	private static function getInstance()
	{
		return !self::$instance ? new PMD : self::$instance;
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

	public static function prepare($component,$name='default')
	{
		self::$component = $component;
		self::$name = $name;

		return self::getInstance();
	}

	public function set($el,$val)
	{
		if( !$el ) throw new \ErrorException("Element {$el} invalid", 1);
		
		self::$setContainer[$el] = $val;

		return self::getInstance();
	}

	public function addAttributeTo($el,$args=array())
	{
		if(!$el) throw new \ErrorException("Element is required", 1);
		if(!$args) throw new \ErrorException("Argument 2 is required", 1);
		
		self::$addToContainer[$el] = $args;
		
		return self::getInstance();
	}

	public function get($config=array())
	{
		$html = self::render(self::$component,self::$name,self::$setContainer,$config);

		if( self::$addToContainer ) {
			foreach (self::$addToContainer as $el => $arr) {
				$dom = new Dom($html);
				if($arr) {
					foreach ($arr as $k => $v) {
						$dom->find($el)->attr($k,$v);
						$html = $dom->output;
					}
				}
			}
		}
		
		return $html;
	}
}
