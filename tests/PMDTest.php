<?php
use PHPUnit_Framework_TestCase as TestCase;
use PMD\PMD;

class PMDTest extends TestCase {
	
	public function testSetConfig()
	{
		$this->assertNotNull(PMD::setConfig('template_di','src/Templates'));
	}

	public function testGetConfig()
	{
		$this->assertEquals('src/Templates', PMD::getConfig('template_di'));
	}

	public function testPrepareWithoutSet()
	{
		$card = PMD::prepare('Cards','default')->find('.mdl-card__menu')->attr('id','test123')->render();
		$this->assertNotNull($card);
	}

	public function testPrepareWSet()
	{
		$card = PMD::prepare('Cards','default')
		->set('class','myclass')
		->find('h2')->addClass('asdf');
		$this->assertNotNull($card);	
	}

	public function testRender()
	{
		$this->assertNotNull(PMD::render('Cards',['title'=>'PHP']));
	}

	public function testCard()
	{
		/**
		 * Retornar html a cada componente chamado,
		 * verificar o load de html no file do twig 
		 */
		PMD::grid(['cols'=>15])->add('Cards',['qtd'=>4],function($card){
			print_r($card->components);
		});
	}
}