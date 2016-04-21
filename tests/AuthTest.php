<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Maxic\DleAuth\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Check auth failed with invalid credentials
     *
     * @return void
     */
    public function testAuthFailed()
    {
        $this->visit('/login')
            ->submitForm('Login', [
                'email' => 'me@example.com',
                'password' => 'secret'
            ])
            ->see(trans('auth.failed'));
    }

    public function testAuthSuccess()
    {

        $user = factory(Maxic\DleAuth\User::class)
            ->create();

        $this->visit('/login')
            ->submitForm('Login', [
                'email' => $user->email,
                'password' => 123456
            ])
            ->dontSee(trans('auth.failed'))
            ->see('Your Application\'s Landing Page.');
        
    }
}
