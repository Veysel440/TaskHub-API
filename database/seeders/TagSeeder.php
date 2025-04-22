<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Önemli', 'type' => 'priority'],
            ['name' => 'Acil', 'type' => 'priority'],
            ['name' => 'Kişisel', 'type' => 'category'],
            ['name' => 'İş', 'type' => 'category'],
            ['name' => 'Toplantı', 'type' => 'event'],
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'type' => $tag['type'],
            ]);
        }
    }
}
