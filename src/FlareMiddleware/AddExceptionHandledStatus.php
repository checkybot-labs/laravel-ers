<?php

namespace CheckybotLabs\LaravelErs\FlareMiddleware;

use Closure;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\FlareMiddleware;
use CheckybotLabs\LaravelErsClient\Report;
use Spatie\Backtrace\Backtrace;
use Throwable;

class AddExceptionHandledStatus implements FlareMiddleware
{
    public function handle(Report $report, Closure $next)
    {
        $frames = Backtrace::create()->limit(40)->frames();
        $frameCount = count($frames);

        try {
            foreach ($frames as $i => $frame) {
                // Check first frame, probably Illuminate\Foundation\Exceptions\Handler::report()
                // Next frame should be: Illuminate/Foundation/helpers.php::report()

                if ($frame->method !== 'report') {
                    continue;
                }

                if ($frame->class === null) {
                    continue;
                }

                if ($i === $frameCount - 1) {
                    continue;
                }

                if ($frames[$i + 1]->class !== null) {
                    continue;
                }

                if ($frames[$i + 1]->method !== 'report') {
                    continue;
                }

                $report->handled();

                break;
            }
        } catch (Throwable) {
            // Do nothing
        }

        return $next($report);
    }
}
