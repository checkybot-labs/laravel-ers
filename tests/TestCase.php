<?php

namespace CheckybotLabs\LaravelFlare\Tests;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use CheckybotLabs\LaravelErsClient\Glows\Glow;
use CheckybotLabs\LaravelErsClient\Report;
use CheckybotLabs\LaravelErs\Facades\Flare;
use CheckybotLabs\LaravelErs\FlareServiceProvider;
use CheckybotLabs\LaravelFlare\Tests\TestClasses\FakeTime;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MakesHttpRequests;

    protected $fakeClient = null;

    protected function setUp(): void
    {
        // ray()->newScreen($this->getName());

        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        config()->set('flare.key', 'dummy-key');

        return [FlareServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Flare' => Flare::class,
        ];
    }

    public function useTime(string $dateTime, string $format = 'Y-m-d H:i:s')
    {
        $fakeTime = new FakeTime($dateTime, $format);

        Report::useTime($fakeTime);
        Glow::useTime($fakeTime);
    }

    public function createRequest($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null): Request
    {
        $files = array_merge($files, $this->extractFilesFromDataArray($parameters));

        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri),
            $method,
            $parameters,
            $cookies,
            $files,
            array_replace($this->serverVariables, $server),
            $content
        );

        return Request::createFromBase($symfonyRequest);
    }
}
