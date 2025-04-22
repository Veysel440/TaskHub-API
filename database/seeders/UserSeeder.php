<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ayşe Kaya',
                'email' => 'ayse@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mehmet Demir',
                'email' => 'mehmet@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
