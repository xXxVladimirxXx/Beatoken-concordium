<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'superadmin'],
            ['name' => 'admin'],
            ['name' => 'author'],
            ['name' => 'user'],
            ['name' => 'middleman'],
            ['name' => 'withdraw_manager'],
            ['name' => 'certified']
        ];

        foreach ($items as $item) {
            Role::create($item);
        }
    }
}
