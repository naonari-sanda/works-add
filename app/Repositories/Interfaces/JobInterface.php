<?php

namespace App\Repositories\Interfaces;

interface JobInterface
{
    /**
     * 全ての求人を取得
     *
     *@return object
     */
    public function getAllJobs(): object;
}
