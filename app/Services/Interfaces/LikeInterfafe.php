<?php

namespace App\Services\Interfaces;

interface LikeInterface
{
    /**
     * いいね登録
     *
     *@param int $id
     *@param int $user_id
     *@param string $ip
     *@return void
     */
    public function like(int $job_id, int $user_id, string $ip): void;

    /**
     * いいね解除
     *
     *@param int $job_id
     *@param int $user_id
     *@param string $ip
     *@return void
     */
    public function unlike(int $job_id, int $user_id, string $ip): void;

    /**
     * いいねチェック
     *
     *@param int $job_id
     *@param int $user_id
     *@param string $ip
     *@return bool
     */
    public function checkLiked(int $job_id, ?int $user_id, string $ip): bool;
}
