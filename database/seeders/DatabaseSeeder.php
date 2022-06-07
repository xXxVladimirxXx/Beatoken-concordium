<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            RolesTableSeeder::class,
            SettingsSeeder::class,
            UsersTableSeeder::class,
        ];

        foreach ($classes as $class) {
            $this->call($class);
        }
    }
}
