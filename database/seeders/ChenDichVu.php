<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
class ChenDichVu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $ten_dich_vu = ['Khám dịch vụ','Khám tim mạch','Khoa nội tổng quát','Khoa niệu','Chỉnh hình xương khớp'];
      $stt = [2,1];
      for ($i=0; $i < 101 ; $i++) { 
        DB::table('services')->insert([
            ['code_services'=>'KIO_'.$i,'name'=>substr(md5(rand()),0,10),'status_active'=>Arr::random($stt),'format_date'=>now()->toDateString(),'der'=>'Dịch vụ hay','created_at'=>now()],
        ]);
      }
    }
}
