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

    /**
     * 求人詳細を取得
     *
     * @param int $id
     * @return object
     */
    public function getJobById(int $id): object;
}
