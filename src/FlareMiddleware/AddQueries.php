<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use CheckybotLabs\LaravelErs\Recorders\QueryRecorder\QueryRecorder;
use CheckybotLabs\LaravelErsClient\Report;

class AddQueries
{
    protected QueryRecorder $queryRecorder;

    public function __construct()
    {
        $this->queryRecorder = app(QueryRecorder::class);
    }

    public function handle(Report $report, $next)
    {
        $report->group('queries', $this->queryRecorder->getQueries());

        return $next($report);
    }
}
