<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(3)->create();

        $users->each(function (\App\Models\User $user) {
            $projects = \App\Models\Project::factory(5)->create();

            $user->projects()->attach($projects->pluck('id')->toArray(), [
                'permission' => 4
            ]);
        });

        $users->first()
            ->projects()
            ->attach([6], [
                'permission' => 3
            ]);

        $users->first()
            ->projects()
            ->attach([7], [
                'permission' => 2
            ]);

        $users->first()
            ->projects()
            ->attach([8], [
                'permission' => 1
            ]);
    }
}
