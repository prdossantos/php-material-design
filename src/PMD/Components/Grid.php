<?php
namespace PMD\Components;

use PMD\Component;

class Grid extends Component{

	public $arg;

	public function __construct($arg=0)
	{
		$this->arg = $arg;
		print $arg;
	}

}