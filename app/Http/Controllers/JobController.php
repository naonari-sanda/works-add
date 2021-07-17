<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\JobInterface;

class JobController extends Controller
{
    private $job;

    public function __construct(JobInterface $job_interface)
    {
        $this->job = $job_interface;
    }
    
    public function index()
    {
        $jobs = $this->job->getAllJobs();

        return view('main.index', compact('jobs'));
    }
}
