<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => Hash::make('123456'),
        ]);

        
    }
}
