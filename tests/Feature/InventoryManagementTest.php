<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Category;
use Illuminate\Support\Str;
use Tests\Feature\AuthenticationTest;

class InventoryManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_added()
    {
        $this->login();
        $response = $this->post('/category', [
            'name' => 'Electronic Accessories'
        ]);
        $category = Category::first();
        $this->assertCount(1, Category::all());
        $this->assertEquals(Str::slug('Electronic Accessories'), $category->slug);
        $response->assertRedirect($category->path());
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->login();
        $response = $this->post('/category', [
            'name' => ''
        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function update_a_category_name()
    {
        $this->a_category_added();
        $category = Category::first();
        $response = $this->patch($category->opPath(), [
            'name' => 'Electronic Accessories Updateed'
        ]);
        $this->assertEquals('Electronic Accessories Updateed', $category->fresh()->first()->name);
        $response->assertRedirect($category->path());
    }

    /** @test */
    public function delete_a_category_added()
    {
        $this->a_category_added();
        $category = Category::first();
        $response = $this->delete($category->opPath());
        $this->assertCount(0, Category::all());
        $response->assertRedirect($category->path());
    }

    /** @test */
    public function check_for_unique_slug_category()
    {
        $this->withOutExceptionHandling();
        $this->login();
        $this->a_category_added();
        $category = Category::first();
        $response = $this->post('/category', [
            'name' => 'Electronic Accessories'
        ]);
        $response->assertSessionHasErrors();
        $response->assertRedirect($category->path());
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function login()
    {
        $this->register();
        $response = $this->post('/login', ['email' => "admin@gmail.com", 'password' => 'admin123']);
        $response->assertRedirect('/category');
    }

    /** @test */
    public function register()
    {
        $response = $this->post('/register', [
            'name' => 'admin',
            'email' => "admin@gmail.com",
            'password' => 'admin123',
            'password_confirmation' => 'admin123'
        ]);
        $response->assertRedirect('/category');
    }
}
