<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user1 = new User();
        $user1->name = 'A';
        $user1->email = 'A@A.A';
        $user1->password = Hash::make('A');
        $user1->save();

        $user2 = new User();
        $user2->name = 'B';
        $user2->email = 'B@B.B';
        $user2->password = Hash::make('B');
        $user2->save();
    }
}
