<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    
    public function labels()
    {
        return $this->hasMany(Label::class);
    }
    
    // 更新日時順にクイズを取得するメソッド
    public function getLatestQuizzes($perPage = 10)
    {
        return $this->quizzes()->latestUpdated()->paginate($perPage);
    }
    
    // 削除日時順にクイズを取得するメソッド
    public function getLatestDeletedQuizzes($perPage = 10)
    {
        return $this->quizzes()->latestDeleted()->paginate($perPage);
    }
}
