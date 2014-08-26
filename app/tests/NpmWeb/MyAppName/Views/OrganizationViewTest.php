<?php

namespace NpmWeb\MyAppName\Views;

use Mockery;
use Symfony\Component\DomCrawler\Crawler;
use View;
use NpmWeb\LaravelTest\BackendTestCase;
use NpmWeb\MyAppName\Models\Organization;

/**
 * View test goals: for each view file, test each different situation of
 * data passed to it (new record, existing, etc.) Is the correct data
 * outputted into the HTML?
 */
class RegistrationViewTest extends BackendTestCase {
	
	public function setUp()
	{
		parent::setUp();

		// We want to use the real controller but mock out the model,
		// so we create a full mock model and pass it into the IoC
		// container.
		$this->reg = Mockery::mock('UnitTestExample\Registration');
		$this->app->instance('UnitTestExample\Registration',$this->reg);
	}

	public function testIndexView()
	{
		// arrange
		// act
	    $crawler = $this->crawl(View::make('organizations.index'));
	   	
	   	// assert
	   	$this->assertCount( 1, $crawler->filter('div#orgs'));
	}

	public function testShowView()
	{
		// arrange
		$model = new Organization();
		$model->name = 'foo';

		// act
	    $crawler = $this->crawl(View::make('organizations.show')
	   							->with('model', $model));
	   	
	   	// assert
	   	$this->assertCount( 1, $crawler->filter('label[for=name] div:contains("'.$model->name.'")'));
	}

	public function testEditViewCreate()
	{
		// arrange
		$model = new Organization();

		// act
	    $crawler = $this->crawl(View::make('organizations.edit')
	   							->with('model', $model));
	   	
	   	// assert
	   	$this->assertCount( 1, $crawler->filterXPath('//input[@name="name"][not(@value)]'));
	}

	public function testEditViewEdit()
	{
		// arrange
		$model = new Organization();
		$model->name = 'foo';

		// act
	    $crawler = $this->crawl(View::make('organizations.edit')
	   							->with('model', $model));
	   	
	   	// assert
	   	$this->assertCount( 1, $crawler->filterXPath('//input[@name="name"][@value="'.$model->name.'"]'));
	}

}
