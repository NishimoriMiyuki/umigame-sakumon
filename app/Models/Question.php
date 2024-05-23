<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'content',
        'answer',
        'quiz_id',
    ];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    
    public static function getAnswerOptions()
    {
        return [
            'yes' => 'はい',
            'no' => 'いいえ',
            'irrelevant' => '関係ありません',
        ];
    }
}
