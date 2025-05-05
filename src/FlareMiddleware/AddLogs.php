<?php

namespace Emefye\LaravelErs\FlareMiddleware;

use Emefye\LaravelErs\Recorders\LogRecorder\LogRecorder;
use Emefye\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use Emefye\LaravelErsClient\Report;

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
