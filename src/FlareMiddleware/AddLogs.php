<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use CheckybotLabs\LaravelErs\Recorders\LogRecorder\LogRecorder;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;

class AddLogs implements FlareMiddleware
{
    protected LogRecorder $logRecorder;

    public function __construct()
    {
        $this->logRecorder = app(LogRecorder::class);
    }

    public function handle(Report $report, $next)
    {
        $report->group('logs', $this->logRecorder->getLogMessages());

        return $next($report);
    }
}
