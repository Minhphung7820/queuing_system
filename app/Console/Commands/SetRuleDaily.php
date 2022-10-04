<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services;

class SetRuleDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
            if (in_array('reset', explode(',', $value->number_rule))) {
                Services::find($value->id)->update([
                    'number_current' => 0001,
                ]);
            }
        }
    }
}
