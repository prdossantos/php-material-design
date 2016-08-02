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

	public static function button($type='',$args=array(),$showIn=true) { 
		$component = self::prepare('Button:'.$type,$args); 
		if($showIn) return $component->get(); 
		else return $component; 
	}
	public static function link($type='',$args=array(),$showIn=true) { 
		$component = self::prepare('Link:'.$type,$args); 
		if($showIn) return $component->get(); 
		else return $component; 
	}
	public static function cards($type='',$args=array(),$showIn=true) { 
		$component = self::prepare('Cards:'.$type,$args); 
		if($showIn) return $component->get(); 
		else return $component; 
	}
	public static function grid($type='',$args=array(),$showIn=true) { 
		$component = self::prepare('Grid:'.$type,$args); 
		if($showIn) return $component->get(); 
		else return $component; 
	}
	public static function dialog($type='',$args=array(),$showIn=true) { 
		$component = self::prepare('Dialog:'.$type,$args); 
		if($showIn) return $component->get(); 
		else return $component; 
	}

}
