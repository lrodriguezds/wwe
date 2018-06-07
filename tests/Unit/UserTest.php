<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserTest extends TestCase
{

    public function test_can_save_user()
    {
        
        $data = [
            'name' => 'User test name',
            'email' => 'user@example.com',
            'password' => '123456',
        ];

        $user = User::create($data);

        $found_user = User::where('email', $data['email'])->first();

        $this->assertEquals($found_user->name, $data['name']);
        $this->assertEquals($found_user->email, $data['email']);
        $this->assertEquals($found_user->password, $data['password']);
    }
}
