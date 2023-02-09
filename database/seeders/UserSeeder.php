<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 11; $i++) {
            User::create([
                "name" => Str::random(8),
                "email" => Str::random(10) . "@" . Str::random(5) . "." . "com",
                "password" => Hash::make("password")
            ]);
        }
    }
}
