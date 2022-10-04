<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
class ChenThietBi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Samsung','Daikin','Toshiba','Kiosk'];
        $type = [2,1];
        $status = [2,1];
        for ($i = 0; $i < 100; $i++) {
            DB::table('devices')->insert([
                ['code_devices'=>'h'.$i,'status_active'=>Arr::random($status),'status_connect'=>Arr::random($status),'type_device'=>Arr::random($type),'name'=>Arr::random($name),'ip_address'=>'192.168.1.10','slug'=>Str::slug(Arr::random($name)),'services'=>'Chỉnh hình xương khớp,Khoa niệu,Khám tim mạch','nameLogin'=>substr(md5(rand()),0,5),'password'=>substr(md5(rand()),0,5),'created_at'=>now()],
            ]);
        }
    }
}
