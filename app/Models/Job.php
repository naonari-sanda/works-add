<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Job extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // JSONに含めるアクセサ
    protected $appends = [
        'like_count', 'like_by_user'
    ];

    /**
     * リレーションシップ likesテーブル
     */
    public function likes()
    {
        return $this->belongsToMany('App\Models\User', 'likes')->withTimestamps();
    }

    /**
     * アクセサ いいねカウント
     *
     * @return int
     */
    public function getLikeCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * アクセサ ユーザーID取得
     *
     * @return boolean
     */
    public function getLikeByUserAttribute()
    {
        if (Auth::guest()) {
            return 0;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::id();
        });
    }
}
