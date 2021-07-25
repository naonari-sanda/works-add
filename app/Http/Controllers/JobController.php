<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\JobInterface;
use App\Services\Interfaces\LikeInterface;
use Barryvdh\Reflection\DocBlock\Type\Collection;

class JobController extends Controller
{
    private $job;

    public function __construct(
        JobInterface $job_interface
    ) {
        $this->job  = $job_interface;
    }
    
    /**
     * メインページ求人取得
     *
     * @return object
     */
    public function index(): object
    {
        $jobs = $this->job->getAllJobs();

        return view('pages.index', compact('jobs'));
    }

    /**
     * 求人詳細を取得
     *
     * @param int $id
     * @return object
     */
    public function show(int $id): object
    {
        $job = $this->job->getJobById($id);

        return view('pages.detail', compact('job'));
    }
}
