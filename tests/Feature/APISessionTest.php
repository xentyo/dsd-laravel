<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APISessionTest extends TestCase
{
    public function testRegister()
    {
        $data = [
            'name' => 'Firstname Lastname',
            'email' => 'example@email.com',
            'password' => 's3cur3p4S5@w0rd',
            'confirmation_password' => 's3cur3p4S5@w0rd'
        ];
        $response = $this->post('api/v1/register', $data);
        if ($response->status() == 401) {
            $response->assertJsonStructure(['errors' => ['email']]);
        } elseif ($response->status() == 200) {
            $response->assertJsonStructure(['name', 'email', 'updated_at', 'created_at']);
        }
    }

    public function testLogin()
    {
        $data = [
            'email' => 'example@email.com',
            'password' => 's3cur3p4S5@w0rd'
        ];
        $response = $this->post('/api/v1/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        File::put('storage/framework/testing/token', $response->json(['token']));
    }

    public function testLogout()
    {
        $token = File::get('storage/framework/testing/token');
        $headers = [
            'Authorization' => "Bearer $token"
        ];
        $response = $this->post('/api/v1/logout', [], $headers);
        $response->assertStatus(200);
    }
}
