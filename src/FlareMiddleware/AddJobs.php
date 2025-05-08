<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use CheckybotLabs\LaravelErs\Recorders\JobRecorder\JobRecorder;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;

class AddJobs implements FlareMiddleware
{
    protected JobRecorder $jobRecorder;

    public function __construct()
    {
        $this->jobRecorder = app(JobRecorder::class);
    }

    public function handle(Report $report, $next)
    {
        if ($job = $this->jobRecorder->getJob()) {
            $report->group('job', $job);
        }

        return $next($report);
    }
}
