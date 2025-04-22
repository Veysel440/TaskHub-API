<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TaskTagSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = Task::all();
        $tags = Tag::all()->pluck('id')->toArray();


        if (empty($tags)) {
            return;
        }

        foreach ($tasks as $task) {
            $count = rand(0, min(3, count($tags)));
            if ($count === 0) continue;

            $randomTags = Arr::random($tags, $count);
            $task->tags()->attach((array) $randomTags);
        }
    }
}
