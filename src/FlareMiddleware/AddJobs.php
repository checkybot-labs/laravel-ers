<?php

namespace Emefye\LaravelErs\FlareMiddleware;

use Emefye\LaravelErs\Recorders\JobRecorder\JobRecorder;
use Emefye\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use Emefye\LaravelErsClient\Report;

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
