<?php

namespace CheckybotLabs\LaravelErs\Exceptions;

use CheckybotLabs\LaravelErs\Recorders\DumpRecorder\HtmlDumper;
use CheckybotLabs\LaravelErsClient\Contracts\ProvidesFlareContext;
use ErrorException;

class ViewException extends ErrorException implements ProvidesFlareContext
{
    /** @var array<string, mixed> */
    protected array $viewData = [];

    protected string $view = '';

    /**
     * @param array<string, mixed> $data
     *
     * @return void
     */
    public function setViewData(array $data): void
    {
        $this->viewData = $data;
    }

    /** @return array<string, mixed> */
    public function getViewData(): array
    {
        return $this->viewData;
    }

    public function setView(string $path): void
    {
        $this->view = $path;
    }

    protected function dumpViewData(mixed $variable): string
    {
        return (new HtmlDumper())->dumpVariable($variable);
    }

    /** @return array<string, mixed> */
    public function context(): array
    {
        $context = [
            'view' => [
                'view' => $this->view,
            ],
        ];

        $context['view']['data'] = array_map([$this, 'dumpViewData'], $this->viewData);

        return $context;
    }
}
