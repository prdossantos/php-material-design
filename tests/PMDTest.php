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

	public function testPrepare()
	{
		$card = PMD::prepare('Cards','default')
		->set('class','myclass')
		->get();
		$this->assertNotNull($card);
	}

	public function testRender()
	{
		$this->assertNotNull(PMD::render('Cards',['title'=>'PHP']));
	}
}