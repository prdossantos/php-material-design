<?php
namespace PMD\Components;

use PMD\Component;

class Cards extends Component{

	public $args;
	public $callback;

	public function __construct($args,$callback=null)
	{

		$this->args = $args;
		$this->callback = $callback;

		$this->register('Cards',$args);

		if( is_callable($this->callback) ) {
			$callback($this);
		}
	}

}