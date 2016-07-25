<?php
namespace PMD\Components;

use PMD\Component;

class Grid extends Component{

	public $grids;

	public function __construct($grids=0)
	{
		$this->grids = $grids;

		$this->register('Grid',$grids);
	}

}