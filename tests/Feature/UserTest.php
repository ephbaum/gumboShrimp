<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testLoginRandomAdmin()
    {
        $response = $this->loginRandomAdmin();

        $response->assertStatus(200);
        $this->assertStringContainsString('token', $response->content());
        $this->assertStringContainsString('user', $response->content());
    }

    public function testCurrentUser()
    {
        $response = $this->loginRandomAdmin();
        $response->assertStatus(200);

        $header = [];
        $header['Accept'] = 'application/json';
        $header['Authorization'] = 'Bearer ' . $this->token;

        $currentUser = $this->get("/api/user", $header);
        $currentUser->assertStatus(200);
    }

    public function testLogout()
    {
        $response = $this->logoutUser();
        $response->assertStatus(204);
    }

    public function testRegisterUser()
    {
        $user = factory(User::class)->make();
        
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response->assertStatus(201)->assertJsonStructure([
            "user" => [
                'id',
                'name',
                'email',
                'role',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
            "message",
            "status"
        ]);

        // delete the user we just made
        User::where('email', $user->email)->first()->delete();
    }

    public function testRegisterFailsWithInvalidEmail()
    {
        $user = factory(User::class)->make();
        
        $data = [
            'name' => $user->name,
            'email' => "THIS IS NOT A VALID EMAIL",
            'role' => $user->role,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token
        ];

        $response = $this->json('POST', '/api/register', $data);
        $response->assertStatus(422);
        $this->assertSame('The given data was invalid.', $response->getData()->message);
        $this->assertStringContainsString('The email must be a valid email address.', json_encode($response->getData()));
    }

    public function testRegisterFailsWithNoName()
    {
        $user = factory(User::class)->make();
        
        $data = [
            'name' => null,
            'email' => $user->email,
            'role' => $user->role,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token
        ];

        $response = $this->json('POST', '/api/register', $data);
        $response->assertStatus(422);
        $this->assertSame('The given data was invalid.', $response->getData()->message);
        $this->assertStringContainsString('The name field is required.', json_encode($response->getData()));
    }

    public function testRegisterFailsWithNoRole()
    {
        $user = factory(User::class)->make();
        
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => null,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token
        ];

        $response = $this->json('POST', '/api/register', $data);
        $response->assertStatus(422);
        $this->assertSame('The given data was invalid.', $response->getData()->message);
        $this->assertStringContainsString('The role field is required.', json_encode($response->getData()));      
    }

    public function testRegisterFailsWithNoPassword()
    {
        $user = factory(User::class)->make();
        
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'email_verified_at' => $user->email_verified_at,
            'password' => null,
            'remember_token' => $user->remember_token
        ];

        $response = $this->json('POST', '/api/register', $data);
        $response->assertStatus(422);
        $this->assertSame('The given data was invalid.', $response->getData()->message);
        $this->assertStringContainsString('The password field is required.', json_encode($response->getData()));      
    }
}
