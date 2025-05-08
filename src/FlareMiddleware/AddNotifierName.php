<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;

class AddNotifierName implements FlareMiddleware
{
    public const NOTIFIER_NAME = 'Laravel Client';

    public function handle(Report $report, $next)
    {
        $report->notifierName(static::NOTIFIER_NAME);

        return $next($report);
    }
}
