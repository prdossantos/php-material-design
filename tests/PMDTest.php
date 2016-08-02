<?php
use PHPUnit_Framework_TestCase as TestCase;
use PMD\PMD;

class PMDTest extends TestCase {
	
	public function testRender()
	{
		$this->assertNotNull(PMD::render('Cards:default',['title'=>'PHP']));
	}

	public function testPrepare()
	{
		$card = PMD::render('Cards:default',[
			'title'=>'PHP é',
			'actions'=>[
				'links'=>[
					'class' => 'sup-class',
					['text'=>'teste','href'=>'/#'],
					['text'=>'asdf 2','href'=>'/#asdf']
				],
				'menu'=>[
					'buttons' =>[
						['text'=>'asdfasdf']
					]
				]
			]
		]);
		$grid = PMD::prepare('Grid',['content'=>$card]);
		// print $card;
		$this->assertNotNull($grid->get());
	}

	public function testButton()
	{
		$component = PMD::button('default',['title'=>'teste']);
		$this->assertNotNull($component);
	}
	public function testLink()
	{
		$component = PMD::link('default',['title'=>'teste']);
		$this->assertNotNull($component);
	}
	public function testCard()
	{
		$component = PMD::cards('default',['title'=>'teste']);
		$this->assertNotNull($component);
	}

	public function testGrid()
	{
		$component = PMD::grid('default',['title'=>'teste']);
		$this->assertNotNull($component);
	}

	public function testDialog()
	{
		$component = PMD::dialog('default',['title'=>'teste']);
		$this->assertNotNull($component);
	}
}