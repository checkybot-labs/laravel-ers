<?php

namespace CheckybotLabs\LaravelErs\Facades;

use CheckybotLabs\LaravelErs\Support\SentReports;
use CheckybotLabs\LaravelErsClient\Flare as FlareClient;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static void glow(string $name, string $messageLevel = \CheckybotLabs\LaravelErsClient\Enums\MessageLevels::INFO, array $metaData = [])
 * @method static void context($key, $value)
 * @method static void group(string $groupName, array $properties)
 *
 * @see \CheckybotLabs\LaravelErsClient\Flare
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
