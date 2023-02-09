<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 11; $i++) {
            Task::create([
                "title"=>Str::random(15),
                "description"=>Str::random(60),
                "user_id"=> rand(1,10),
                "status" => "Pending",
                "front_date"=>date("Y.m.d")

            ]);
        }
    }
}
