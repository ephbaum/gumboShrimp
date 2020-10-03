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
}
