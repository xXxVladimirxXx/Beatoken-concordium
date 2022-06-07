<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'superadmin', 'email' => 'superadmin@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('zZurAs3s'), 'role_id' => 1],
            ['name' => 'admin', 'email' => 'admin@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('3L24qZyG'), 'role_id' => 2],
            ['name' => 'author', 'email' => 'author@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('WjaVVyz5'), 'role_id' => 3],
            ['name' => 'user', 'email' => 'user@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('sMQ5LuFm'), 'role_id' => 4],
            ['name' => 'middleman', 'email' => 'middleman@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('V1jmF4ns'), 'role_id' => 5],
            ['name' => 'withdraw_manager', 'email' => 'withdraw_manager@beatoken.com', 'email_verified_at' => '2021-09-22 00:00:00', 'password' => bcrypt('rUqc2xgB'), 'role_id' => 6]
        ];

        foreach ($items as $item) {
            User::create($item);
        }
    }
}
