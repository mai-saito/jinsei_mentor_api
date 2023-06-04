<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'title' => '私の人生年表',
                'description' => Str::random(100),
                'user_id' => 1,
            ],
            [
                'title' => 'きなこの毎日',
                'description' => Str::random(100),
                'user_id' => 2,
            ],
        ];

        foreach ($params as $param) {
            DB::table('timelines')->insert($param);
        }
    }
}
