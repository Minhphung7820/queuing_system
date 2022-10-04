<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ChenLoaiThietBi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_devices')->insert([
            ['name'=>'Display Counter','slug'=>Str::slug('Display Counter'),'describe'=>'Thiết bị đẹp','created_at'=>now()],
            ['name'=>'Kiosk','slug'=>Str::slug('Kiosk'),'describe'=>'Thiết bị đẹp','created_at'=>now()],
        ]);
    }
}
