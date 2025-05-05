<?php

namespace Emefye\LaravelErs\Facades;

use Emefye\LaravelErs\Support\SentReports;
use Emefye\LaravelErsClient\Flare as FlareClient;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static void glow(string $name, string $messageLevel = \Emefye\LaravelErsClient\Enums\MessageLevels::INFO, array $metaData = [])
 * @method static void context($key, $value)
 * @method static void group(string $groupName, array $properties)
 *
 * @see \Emefye\LaravelErsClient\Flare
 */
class Flare extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FlareClient::class;
    }

    public static function handles(Exceptions $exceptions): void
    {
        $exceptions->reportable(static function (Throwable $exception): FlareClient {
            $flare = app(FlareClient::class);

            $flare->report($exception);

            return $flare;
        });
    }

    public static function sentReports(): SentReports
    {
        return app(SentReports::class);
    }
}
