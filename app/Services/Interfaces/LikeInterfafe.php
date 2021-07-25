<?php

namespace App\Services\Interfaces;

interface LikeInterface
{
    /**
     * いいね登録
     *
     *@param int $job_id
     *@return void
     */
    public function like(int $job_id, int $user_id): void;

    /**
     * いいね解除
     *
     *@param
     *@return
     */
    public function unlike($job_id, int $user_id);
}
