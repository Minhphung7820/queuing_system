<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChenUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => 'tmp',
                'fullname' => 'Trương Minh Phụng',
                'email' => substr(md5(rand()), 0, 5) . '@gmail.com',
                'password' => bcrypt('123'),
                'avt' => 'undraw_profile.svg',
                'phone' => '0962761246',
                'password_2' => '123',
                'created_at' => now(),
                'role' => 1,
            ]);
        }
    }
}
