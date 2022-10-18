<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Group::create([
        //     'name' => 'Group 1',
        // ]);

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);

        // \App\Models\Student::create([
        //     'group_id' => '1',
        //     'name' => 'denis',
        //     'number' => '1',
        //     'email' => 'denis@example.com',
        //     'password' => Hash::make('123456'),
        //     'phone_number' => '984937392',
        //     'school_origin' => 'UTY',
        // ]);
    }
}
