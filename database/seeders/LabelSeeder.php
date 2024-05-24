<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Label;
use App\Models\User;

class LabelSeeder extends Seeder
{
    public function run()
    {
        $labels = [
            ['name' => 'Science'],
            ['name' => 'Math'],
            ['name' => 'History'],
            ['name' => 'Literature'],
            ['name' => 'Art'],
        ];

        $colors = [
            '#dc2626', // 赤
            '#ca8a04', // 黄色
            '#16a34a', // 緑
            '#2563eb', // 青
            '#4f46e5', // 藍色
            '#9333ea', // 紫
            '#db2777', // ピンク
            '#4b5563', // 灰色
            '#059669', // エメラルド
            '#0d9488', // ティール
            '#0891b2', // シアン
            '#d97706', // 琥珀色
            '#65a30d', // ライム
            '#ea580c', // オレンジ
            '#7c3aed', // バイオレット
            '#c026d3', // フクシア
            '#0284c7', // 空色
            '#525252', // ニュートラル
        ];

        foreach ($labels as $label) {
            $label['color'] = $colors[array_rand($colors)];
            $label['user_id'] = 1;
            Label::create($label);
        }
    }
}
