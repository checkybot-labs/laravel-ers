<?php

namespace Emefye\LaravelErs\ContextProviders;

use Emefye\LaravelErsClient\Context\ContextProvider;
use Emefye\LaravelErsClient\Context\ContextProviderDetector;
use Illuminate\Http\Request;
use Livewire\LivewireManager;

class LaravelContextProviderDetector implements ContextProviderDetector
{
    public function detectCurrentContext(): ContextProvider
    {
        if (app()->runningInConsole()) {
            return new LaravelConsoleContextProvider($_SERVER['argv'] ?? []);
        }

        $request = app(Request::class);

        if ($this->isRunningLiveWire($request)) {
            return new LaravelLivewireRequestContextProvider($request, app(LivewireManager::class));
        }

        return new LaravelRequestContextProvider($request);
    }

    protected function isRunningLiveWire(Request $request): bool
    {
        return $request->hasHeader('x-livewire') && $request->hasHeader('referer');
    }
}
