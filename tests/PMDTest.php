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
		PMD::grid('grid: 3')->add('Cards','cards: 4',function($card){
			print $card.' >>!';
		});
	}
}