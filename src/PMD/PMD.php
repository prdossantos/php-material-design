<?php
namespace PMD;

use PMD\PHPMaterialDesign;

class PMD{


	public static function render($component,$args=array(),$config=array())
	{
		if(strpos($component, ':') !== false) {
			list($component,$type) = explode(':',$component);
			$args['pmd_component_type'] = $type; 
		}
		
		$template = new PHPMaterialDesign($component,$args,$config);
		return $template->render();
	}

	public static function prepare($component,$args=array(),$config=array())
	{
		if(strpos($component, ':') !== false) {
			list($component,$type) = explode(':',$component);
			$args['pmd_component_type'] = $type; 
		}

		$template = new PHPMaterialDesign($component,$args,$config);
		return $template->prepare();
	}

	public static function cards($type='',$args=array()) { return $this->prepare('Cards:{$type}',$args); }
	public static function grid($type='',$args=array()) { return $this->prepare('Grid:{$type}',$args); }

}
