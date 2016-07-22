<?php
namespace PHPLJ;
/**
 * $dom = new Dom($html);
 * $dom->find('h2[data-id=asdf]')->attr('id','234');
 * $dom->find('#234')->attr('data-test','123asdf');
 * $html = $dom->output;
 * 
 * $dom = new Dom($html);
 * $dom->find('.material-icons')->attr('id','ffff');
 * $html = $dom->output;
 *
 * $dom = new Dom($html);
 * print_r($dom->find('#ffff')->attr('class'));
 *
 * $dom = new Dom($html);
 * print_r($dom->find('#ffff')->html());
 *
 * $dom = new Dom($html);
 * $dom->find('#ffff')->html('<b>asdfasdfasdf</b>');
 * $html = $dom->output;
 *
 * $dom = new Dom($html);
 * $dom->find('a')->attr('href','http://');
 * $html = $dom->output;
 * 
 */
class Dom {

	public $dom;
	public $html;
	private $xpath;
	public $items;
	public $output;

	public function __construct($html)
	{

		if(!$html)
			throw new \ErrorException("Argument 1 is required", 1);
			
		$this->dom = new \DOMDocument();

		if(is_file($html))
			$this->dom->loadHTMLFile($html);
		else
			$this->dom->loadHTML($html);


		$this->dom->formatOutput = true;

		$this->xpath = new \DOMXpath($this->dom);
	}

	public function find($el)
	{
		
		$el = $this->jquery2dom($el);
		
		if( isset($el['id']) ) {
		 	$this->items[] = $this->dom->getElementById($el['id']);
		}
		if( isset($el['class']) ) {
		 	$elements = $this->dom->getElementsByTagName('*');
		 	if($elements) {
		 		foreach ($elements as $element) {
		 			if( strpos($element->getAttribute('class'),$el['class']) !== false) {
		 				$this->items[] = $element;
		 			}
		 		}
		 	}
		}
		if( isset($el['tag']) )  {
			if( is_array($el['tag']) ) {
				foreach ($el['tag'] as $tag => $attr) {
	 				$elements = $this->dom->getElementsByTagName($tag);
					if($elements) {
						foreach ($elements as $element) {
							foreach ($attr as $k => $v) {
								if($element->getAttribute($k) == $v) {
									$this->items[] = $element;
								}	
							}
						}
					}
				}
			} else {
				$elements = $this->dom->getElementsByTagName($el['tag']);
				if($elements) {
					foreach ($elements as $element) {
						$this->items[] = $element;
					}
				}
			}
		} 
		return $this;
	}

	public function attr($attr,$val='')
	{
		if($this->items) {
			foreach ($this->items as $element) {
				if(!$val)
					return $element->getAttribute($attr);

				$element->setAttribute($attr,$val);
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}

		return $this;
	}

	public function html($val='')
	{
		if($this->items) {
			foreach ($this->items as $element) {
				if(!$val)
					return trim($element->nodeValue);

				$element->nodeValue = $val;
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		} else {
			return null;
		}

		return $this;	
	}

	/**
	 * Função para manipulação do atributo style
	 * @param    string|array $arg1 caso string, será uma propriedade. Caso array o index será uma propriedade
	 *                              e o valor será o valor da propriedade. Ex: String('color'). Array(['color'=>'white'])
	 * @param    string $arg2  	apenas será utilizado quando o $arg1 for uma string e será o valor do atributo
	 * @return   Instance       \Dom
	 */
	public function css($arg1,$arg2='')
	{
		if( $this->items ) {
			foreach ( $this->items as $element) {
				if( is_array($arg1) && $arg1 ) {
					$css = ''; $end = ','; $i=0;
					foreach ($arg1 as $key => $value) {
						if(count($arg1) == ++$i) $end = '';
						$css .= $key.':'.$value.$end;
					}
					$element->setAttribute('style',$css);
				} else if( is_string($arg1) && $arg1 && $arg2 ) {
					$element->setAttribute('style',$arg1.':'.$arg2);
				}
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}
		return $this;
	}

	/**
	 * Adiciona uma nova classe ao elemento
	 * @param string $class classe a ser adicionada
	 * @return instance \Dom
	 */
	public function addClass($class)
	{
		if(empty($class)) throw new \ErrorException("Argument 1 is required", 1);
		
		if( $this->items ) {
			foreach ( $this->items as $element) {
				$oldClass = str_replace($class,'',$element->getAttribute('class'));
				$element->setAttribute('class',$oldClass.' '.$class);
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}
		return $this;
	}

	/**
	 * Remove uma classe do elemento
	 * @param string $class classe a ser removida
	 * @return instance \Dom
	 */
	public function removeClass($class)
	{
		if(empty($class)) throw new \ErrorException("Argument 1 is required", 1);
		
		if( $this->items ) {
			foreach ( $this->items as $element) {
				$oldClass = trim(str_replace($class,'',$element->getAttribute('class')));
				$element->setAttribute('class',$oldClass);
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}
		return $this;
	}

	/**
	 * Verifica se a classe existe no elemento
	 * @param string $class classe a ser adicionada
	 * @return instance \Dom
	 */
	public function hasClass($class)
	{
		if(empty($class)) throw new \ErrorException("Argument 1 is required", 1);
		
		if( $this->items ) {
			$items = $this->items;
			$this->items = [];
			foreach ( $items as $element) {
				$oldClass = $element->getAttribute('class');
				if(strpos($oldClass, $class) !== false)
					$this->items[] = $element;
			}
		}
		return $this;
	}

	/**
	 * Adiciona um conteúdo ao final do elemento 
	 * @param  string $html conteúdo que será adicionado, aceita html e texto.
	 * @return instance     \Dom
	 */
	public function append($html)
	{
		if(empty($html)) throw new \ErrorException("Argument 1 is required", 1);
		
		if( $this->items ) {
			foreach ( $this->items as $element) {
				$node = $this->dom->createTextNode($html);
				$element->appendChild($node);
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}

		return $this;
	}

	/**
	 * Adiciona um conteúdo no inicio do elemento 
	 * @param  string $html conteúdo que será adicionado, aceita html e texto.
	 * @return instance     \Dom
	 */
	public function prepend($html)
	{
		if(empty($html)) throw new \ErrorException("Argument 1 is required", 1);
		
		if( $this->items ) {
			foreach ( $this->items as $element) {
				$node = $this->dom->createTextNode($html);
				$child = $element->firstChild;
				$element->insertBefore($node,$child);
			}
			$this->output = $this->cleanOut($this->dom->saveHTML());
		}

		return $this;
	}

	/**
	 * Imprime ou retorna o html tratado.
	 * @param    boolean $print caso TRUE será impresso na tela
	 * @return   string         apenas se a $print for FALSE
	 */
	public function render($print=false)
	{
		if ( $print )
			print $this->output;
		else
			return $this->output;
	}

	/**
	 * Imprime ou retorna o html tratado.
	 * @param    boolean $print caso TRUE será impresso na tela
	 * @return   string         apenas se a $print for FALSE
	 */
	public function save()
	{
		return $this->output;
	}

	public function cleanOut($str)
	{
		$str = explode('<body>',$str);
		$str = str_replace(array('</html>','</body>','&lt;','&gt;'),array('','','<','>'),$str[1]);

		return $str;
	}

	public function jquery2dom($str)
	{
		//#id
		//tag#id
		//.class
		//tag.class x
		//#id.class
		//tag[attr=val]
		$return = array();
		$str = str_replace(array('  '),array(' '),trim($str));

		if(substr($str, 0, 1) == '#'){
			$return['id'] = substr($str,1,strlen($str));
		} else if(strpos($str,'#')) {
			$tag = explode('#',$str);
			$return['tag'] = [$tag[0]=>['id' => $tag[1]]];
		} else if(substr($str, 0, 1) == '.'){
			$return['class'] = substr($str,1,strlen($str));
		} else if(strpos($str,'.')) {
			$tag = explode('.',$str);
			$return['tag'] = [$tag[0]=>['class' => $tag[1]]];
		} else if(strpos($str, '[') !== false ){
			$pos = strpos($str, '[');
			$posf= strpos($str, ']');
			$tag = explode('=',substr($str, $pos+1, ($posf)-($pos+1)));
			$return['tag'] = [substr($str, 0, $pos) => [$tag[0]=>$tag[1]]];
		} else if(strpos($str, ' ') !== false) {

		} else {
			$return['tag'] = $str;
		}
		return $return;
	}
}