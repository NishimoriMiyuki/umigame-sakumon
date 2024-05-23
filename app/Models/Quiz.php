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
}
