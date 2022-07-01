<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_api()
    {
        $user = User::factory()->create(['password' => bcrypt('foo')]);

        $formData = [
            'email'=> $user->email,
            'password'=> 'foo'
        ];
        $this->post('/api/login',$formData)
        ->assertStatus(201);
    }

    public function test_register_api()
    {
        $password = $this->faker->password();

        $formData = [
            'name'=> $this->faker->name(),
            'email'=> $this->faker->email(),
            'password'=> $password,
            'password_confirmation'=> $password
        ];

        $this->post('/api/register',$formData)
        ->assertStatus(201);
    }

    public function test_logout_api()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/api/logout')
        ->assertStatus(200);
    }

    // public function test_show_all_products_api()
    // {
    //     $this->get('/api/products')
    //     ->assertStatus(200);
    // }

    // public function test_show_specific_product_api()
    // {
    //     $this->get('/api/products/search/')
    //     ->assertStatus(200);
    // }

    // public function test_create_api()
    // {
    //     $user = User::factory()->create();

    //     $formData = [
    //         'name'=> 'newtestcreate',
    //         'slug'=> 'new-test-create',
    //         'description'=> 'this is test',
    //         'price'=> '99.99'
    //     ];
    //     $this->actingAs($user)
    //     ->post('/api/products', $formData)
    //     ->assertStatus(201);
    // }
}
