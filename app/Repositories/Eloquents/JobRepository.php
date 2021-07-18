<?php

namespace App\Repositories\Eloquents;

use App\Models\Job;
use App\Repositories\Interfaces\JobInterface;

/**
 * class JobRepository
 */
class JobRepository implements JobInterface
{
    private $job;

    /**
     * Jobモデル取得
     *
     * @param object $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * 全ての求人を取得
     *
     *@return object
     */
    public function getAllJobs(): object
    {
        return $this->job->all();
    }

    /**
     * 求人詳細を取得
     *
     * @param int $id
     * @return object
     */
    public function getJobById(int $id): object
    {
        return $this->job->find($id);
    }
}
