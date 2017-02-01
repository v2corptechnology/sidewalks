<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesTest extends TestCase
{
	use DatabaseMigrations;

	public $user;
	public $userWithoutShop;
	public $shop;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(App\User::class)->create();
		$this->shop = factory(App\Shop::class)->create(['user_id' => $this->user->id]);
		$this->userWithoutShop = factory(App\User::class)->create();
	}

	public function test_categories_are_not_reachable_for_guest() 
	{
        $response = $this->get('/categories');

        $response->assertResponseStatus(302);
	}

	public function test_categories_are_not_reachable_without_a_shop() 
	{
		$this->actingAs($this->userWithoutShop);

        $response = $this->get('/categories');

        $response->assertResponseStatus(302);
	}

	public function test_categories_are_displayed()
	{
		$categories = factory(App\Category::class)->create([
			'shop_id' => $this->shop->id,
			'name' => 'This is the coolest category, ever'
		]);

		$this->actingAs($this->user);
		
        $this->visit('/categories')
        	 ->see('This is the coolest category, ever');
	}

	public function test_user_can_create_category()
	{
		 $this->visit('/register')
	          ->type('Taylor', 'name')
	          ->check('terms')
	          ->press('Register')
	          ->seePageIs('/dashboard');
	}
}
