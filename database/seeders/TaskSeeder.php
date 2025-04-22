<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        $priorities = ['low', 'medium', 'high'];

        foreach ($users as $user) {
            for ($i = 0; $i < rand(3, 8); $i++) {
                Task::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence(3),
                    'is_completed' => $faker->boolean(30),
                    'priority' => $faker->randomElement($priorities),
                ]);
            }
        }
    }
}
