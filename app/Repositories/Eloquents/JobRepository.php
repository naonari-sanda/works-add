<?php

namespace App\Repositories\Eloquents;

use App\Models\Job;

/**
 * class JobRepository
 */
class Jobrepository implements EloquentInterface
{
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * jobモデル
     */
}
