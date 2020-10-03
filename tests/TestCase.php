<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    /** @var string */
    protected $token = '';

    public function loginRandomAdmin()
    {
        $user = User::inRandomOrder()->where('role', 'admin')->first();

        $tokenData = [
            'grant_type' => 'password',
            'email' => trim($user->email),
            'password' => 'password',
            'scope' => ''
        ];

        $response = $this->json('POST', '/api/login', $tokenData);

        $json = json_decode($response->content());

        if($response->getStatusCode() == 200)
        {
            $this->token = $json->token;
        }

        return $response;
    }
}
