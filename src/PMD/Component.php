<?php
namespace PMD;

use PMD\Components\Cards;
use PMD\Components\Grid;
/**
* 
*/
class Component
{
	
	public function add($component,$args='',$callback=null)
	{
		if(is_callable($args)) {
			$callback = $args;
			$args = '';
		}
		switch ($component) {
			case 'Cards':
				return new Cards($args,$callback);
		}
	}

}