<?php

namespace Emefye\LaravelErs\FlareMiddleware;

use Closure;
use Emefye\LaravelErs\Recorders\DumpRecorder\DumpRecorder;
use Emefye\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use Emefye\LaravelErsClient\Report;

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
