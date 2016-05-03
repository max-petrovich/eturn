<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Maxic\DleAuth\DleCrypt;

class DatabaseModelsMassAssignableTest extends TestCase
{
    use DatabaseTransactions;

    public function testModels()
    {
//        Artisan::call('migrate:refresh');

/*        User::create([
            'email' => 'client1@example.com',
            'name' => 'client1',
            'password' => DleCrypt::crypt('123456'),
            'fullname' => 'Анатлоий Валерьянович',
            'user_group' => getRoleId('client')
        ]);

        User::create([
            'email' => 'client2@example.com',
            'name' => 'client2',
            'password' => DleCrypt::crypt('123456'),
            'fullname' => 'Серьгей Мазовка',
            'user_group' => 4,
        ]);*/
    }
}
