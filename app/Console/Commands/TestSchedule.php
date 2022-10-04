<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services;

class TestSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Services::all() as $key => $value) {
            if ($value->date_started == null && $value->date_past == null) {
                Services::find($value->id)->update([
                    'date_started' => 'cc',
                    'date_past' => 'cc'
                ]);
            }
        }
    }
}
