<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;

class AuthTest extends TestCase
{
    public function testRegisterValidation()
    {
        $response = $this->post('/api/register', []);

        $response->assertJsonValidationErrors(['name', 'email', 'password']);
        $response->assertStatus(400);
    }

    public function testRegisterSuccessful()
    {
        Artisan::call('migrate');
        $response = $this->post('/api/register', ['name' => 'test user', 'email' => 'user@test.com', 'password' => '12345678']);
        
        $response->assertJsonStructure(['data', 'access_token', 'token_type']);
        $response->assertStatus(200);
    }
}
