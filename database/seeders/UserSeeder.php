<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@blockstairs.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@blockstairs.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@blockstairs.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@blockstairs.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@blockstairs.com',
            'password' => Hash::make('password'),
        ]);
    }
}
