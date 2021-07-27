<?php

namespace App\Services;

use App\Models\Job;
use App\Models\Like;
use App\Services\Interfaces\LikeInterface;
use PhpParser\Node\Expr\BooleanNot;
use Illuminate\Support\Facades\Auth;

class LikeService implements LikeInterface
{
    // Jobモデル
    private $job;
    private $like;

    public function __construct(
        Job $job,
        Like $like
    ) {
        $this->job = $job;
        $this->like = $like;
    }

    /**
     * いいね登録
     *
     * @param int $job_id
     * @param int $user_id
     * @param string $ip
     *
     */
    public function like(int $job_id, int $user_id, string $ip): void
    {
        $job = $this->job->where('id', $job_id)->first();

        if (! $job) {
            abort(404);
        }

        $this->deleteLike($job, $user_id, $ip);

        // $job->likes()->where('user_id', $user_id)->delete();

        $this->like->job_id = $job_id;
        $this->like->ip = $ip;
        if ($user_id) {
            $this->like->user_id = $user_id;
        }
        $this->like->save();
    }

    /**
     * いいね解除
     *
     *@param int $job_id
     *@param int $user_id
     *@param string $ip
     *@return void
     */
    public function unlike($job_id, int $user_id, string $ip): void
    {
        $job = $this->job->where('id', $job_id)->with('likes')->first();

        if (! $job) {
            abort(404);
        }
        $this->deleteLike($job, $user_id, $ip);
    }

    /**
     * いいね削除
     * @param $job
     * @param int $user_id
     * @param string $ip
     */
    private function deleteLike($job, int $user_id, string $ip): void
    {
        if (!empty($user_id)) {
            $job->likes()->where('user_id', $user_id)->delete();
        } else {
            $job->likes()->where('ip', $ip)->delete();
        }
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
