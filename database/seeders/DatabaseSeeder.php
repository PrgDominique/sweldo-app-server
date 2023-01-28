<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'first_name' => 'Admin',
            'last_name' => 'Account',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => 1
        ]);
        \App\Models\User::create([
            'first_name' => 'Test',
            'last_name' => 'Account',
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        \App\Models\User::factory(100)->create();
        \App\Models\Announcement::factory(10)->create();
    }
}
