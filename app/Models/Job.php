<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * リレーションシップ likesテーブル
     */
    public function likes()
    {
        return $this->belongsToMany('App\Models\Like')->withTimestamps();
    }
}
