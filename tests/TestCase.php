<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, DatabaseMigrations, InteractsWithDatabase;
    
    /** @var string */
    protected $token = '';

    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate',['-vvv' => true]);
        \Artisan::call('passport:install',['-vvv' => true]);
        \Artisan::call('db:seed',['-vvv' => true]);
    }

    /**
     * 
     * @return object
     */
    public function loginRandomAdmin()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('POST', '/api/login');

        $json = json_decode($response->content());

        if($response->getStatusCode() == 200)
        {
            $this->token = $json->token;
        }

        return $response;
    }

    public function logoutUser()
    {
        $response = $this->json('POST', 'api/logout');

        return $response;
    }

    public function get_current_user()
    {
        return Auth::user();
    }
}
