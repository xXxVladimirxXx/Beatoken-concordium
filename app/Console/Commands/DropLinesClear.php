<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\{DropLine, Setting};

class DropLinesClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drop-lines:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all drop lines which have expired';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_drop_payment = Setting::where('key', 'default_time_drop_payment')->pluck('value')->first();
        DropLine::where('time_line', '<', Carbon  ::now()->subSecond($time_drop_payment))->delete();
    }
}