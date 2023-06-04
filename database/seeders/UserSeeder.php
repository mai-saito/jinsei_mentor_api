<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => 'Mai',
                'birthday' => '19920201'
            ],
            [
                'name' => 'きなこ',
                'birthday' => '20141021'
            ],
        ];

        foreach ($params as $param) {
            DB::table('users')->insert($param);
        }
    }
}
