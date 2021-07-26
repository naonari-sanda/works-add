<?php

namespace App\Services;

use App\Models\Job;
use App\Services\Interfaces\LikeInterface;
use PhpParser\Node\Expr\BooleanNot;
use Illuminate\Support\Facades\Auth;

class LikeService implements LikeInterface
{
    // Jobモデル
    private $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * いいね登録
     *
     * @param int $id
     * @return void
     */
    public function like(int $job_id, int $user_id): void
    {
        $job = $this->job->where('id', $job_id)->with('likes')->first();

        if (! $job) {
            abort(404);
        }

        $job->likes()->detach($user_id);
        $job->likes()->attach($user_id);
    }

    /**
     * いいね解除
     *
     *
     */
    public function unlike($job_id, $user_id)
    {
        $job = $this->job->where('id', $job_id)->with('likes')->first();

        if (! $job) {
            abort(404);
        }

        $job->likes()->detach($user_id);
    }

    /**
     * いいね登録確認
     *
     * @param int $job_id
     * @return boolean
     */
    public function is_like(int $job_id): Boolean
    {
        return $this->like->where('job_id', $job_id)->exits();
    }
}
