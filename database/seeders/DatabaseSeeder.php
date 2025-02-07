<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(20)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => '123ewq!'
        ]);

        User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test1@test.com',
            'password' => '111ewq!'
        ]);
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@test.com',
            'password' => '222ewq!'
        ]);

        User::factory()->create([
            'name' => 'Test User 3',
            'email' => 'test3@test.com',
            'password' => '333ewq!'
        ]);

        Task::factory(20)->create();
    }
}
