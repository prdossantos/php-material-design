<?php
namespace PMD;

use PMD\Components\Cards;
use PMD\Components\Grid;
/**
* 
*/
class Component
{
	public $context;
	public $components = [];

	public function add($component,$args='',$callback=null)
	{
		if(is_callable($args)) {
			$callback = $args;
			$args = '';
		}
		// print_r($this);
		$this->context[] = $this;

		return call_user_func_array(array('PMD\Components\\'.$component,'self::__construct'),array($args,$callback));
	}

	public function register($component='',$params=array())
	{
		$this->components[$component] = $params;
	}

}