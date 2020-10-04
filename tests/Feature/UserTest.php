<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testLoginRandomAdmin()
    {
        $response = $this->loginRandomAdmin();

        $response->assertStatus(200);
        $this->assertStringContainsString('token', $response->content());
        $this->assertStringContainsString('user', $response->content());
    }

    public function testLogout()
    {
        $response = $this->logoutUser();
        $response->assertStatus(204);
    }

    public function testCurrentUser()
    {
        $response = $this->loginRandomAdmin();
        $response->assertStatus(200);

        $header = [];
        $header['Accept'] = 'application/json';
        $header['Authorization'] = 'Bearer ' . $this->token;

        $response = $this->get("/api/users/current", $header);
        $response->assertStatus(200);
    }
}
