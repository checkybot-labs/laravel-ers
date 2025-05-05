<?php

namespace Emefye\LaravelErs\FlareMiddleware;

use Emefye\LaravelErs\Recorders\QueryRecorder\QueryRecorder;
use Emefye\LaravelErsClient\Report;

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
