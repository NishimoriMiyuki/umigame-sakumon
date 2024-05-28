<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];
    
    // カラーパレットを定義
    protected static $colors = [
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
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'label_quiz');
    }
    
    // ランダムな色を取得するメソッド
    public static function getRandomColor()
    {
        return self::$colors[array_rand(self::$colors)];
    }
    
    public function colorToRgba($opacity = 0.2)
    {
        list($r, $g, $b) = sscanf($this->color, "#%02x%02x%02x");
        return "rgba($r, $g, $b, $opacity)";
    }
}
