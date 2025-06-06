<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use Closure;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;
use Illuminate\Log\Context\Repository;
use Illuminate\Support\Facades\Context;

class AddContext implements FlareMiddleware
{
    public function handle(Report $report, Closure $next)
    {
        if (! class_exists(Repository::class)) {
            return $next($report);
        }

        $allContext = Context::all();

        if (count($allContext)) {
            $report->group('laravel_context', $allContext);
        }

        return $next($report);
    }
}
