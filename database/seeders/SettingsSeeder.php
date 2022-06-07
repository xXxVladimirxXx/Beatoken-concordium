<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;


class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['key' => 'fee_drop', 'value' => '5'], // percent
            ['key' => 'fee_marketplace', 'value' => '5'], // percent
            ['key' => 'currency_rate_dollar_dkk', 'value' => '6.45'], // kr
            ['key' => 'currency_rate_euro_dkk', 'value' => '7.40'], // kr
            ['key' => 'default_time_drop_line', 'value' => '120'], // seconds
            ['key' => 'default_time_drop_payment', 'value' => '1200'] // seconds
        ];

        foreach ($items as $item) {
            Setting::create($item);
        }
    }
}
