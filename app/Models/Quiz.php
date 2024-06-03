<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'title',
        'story',
        'memo',
        'answer',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_quiz');
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // 更新日時順にクイズを取得するスコープ
    public function scopeLatestUpdated($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
    
    // 削除日時順にクイズを取得するスコープ
    public function scopeLatestDeleted($query)
    {
        return $query->onlyTrashed()->orderBy('deleted_at', 'desc');
    }
    
    public function getQuestionFormatAttribute()
    {
        $format = "【{$this->title}】作問:{$this->user->name}\n{$this->story}";
        // javascriptで使える文字列に変換して返す
        return str_replace(["\r", "\n"], ['\\r', '\\n'], $format);
    }
    
    public function getAnswerFormatAttribute()
    {
        $format = "【真相】\n{$this->answer}";
        return str_replace(["\r", "\n"], ['\\r', '\\n'], $format);
    }
}
