<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LifeEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'timeline_id' => 1,
                'title' => '札幌で生まれる！',
                'description' => '札幌市で生まれました。クラーク博士のふもとに住んでたよ！',
                'slug' => '爆誕！',
                'age' => 0
            ],
            [
                'timeline_id' => 1,
                'title' => '英会話を初めて習った小学校2年生',
                'description' => '友達で英会話を習っている子がいたんだけど、「英会話を習っている」ってフレーズがかっこよすぎて習い始める。今と違って英語への情熱とかは皆無だったなあ・・・(笑)',
                'slug' => 'はじめての英語',
                'age' => 8
            ],
            [
                'timeline_id' => 1,
                'title' => 'オーストラリア短期留学',
                'description' => '高校2年で初めての海外語学留学（たった2週間だけど・・・）。これでオーストラリア大好きになったよね。',
                'slug' => '短期留学',
                'age' => 16
            ],
            [
                'timeline_id' => 1,
                'title' => '休学して語学留学へ',
                'description' => '大学3年の半ばから休学してオーストラリアへ1年間の語学留学。これは本当にいい経験になった・・・。価値観とかはガラッと変わったかも。',
                'slug' => '語学留学',
                'age' => 20
            ],
            [
                'timeline_id' => 2,
                'title' => '生まれて飛行機で札幌に来ました！',
                'description' => '生まれは確か関東？のどこかで、飛行機で荷物と一緒に空輸されてきたよ(笑)何か空港で受け渡されたとき、私はケージの中でうんちまみれだったらしい・・・きっと飛行機内で我慢できなかったんだな。。',
                'slug' => '齋藤家にやってくる！',
                'age' => 0
            ],
            [
                'timeline_id' => 2,
                'title' => 'すくすく育つよ',
                'description' => '元気いっぱいですくすく育ってるよ！',
                'slug' => 'すくすく！',
                'age' => 1
            ],
        ];

        foreach ($params as $param) {
            DB::table('life_events')->insert($param);
        }
    }
}
