<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use Closure;
use CheckybotLabs\LaravelErs\Recorders\DumpRecorder\DumpRecorder;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;

class AddDumps implements FlareMiddleware
{
    protected DumpRecorder $dumpRecorder;

    public function __construct()
    {
        $this->dumpRecorder = app(DumpRecorder::class);
    }

    public function handle(Report $report, Closure $next)
    {
        $report->group('dumps', $this->dumpRecorder->getDumps());

        return $next($report);
    }
}
