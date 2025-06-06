<?php

namespace CheckybotLabs\LaravelErs\Exceptions;

use Spatie\ErrorSolutions\Contracts\ProvidesSolution;
use Spatie\ErrorSolutions\Contracts\Solution;

class ViewExceptionWithSolution extends ViewException implements ProvidesSolution
{
    protected Solution $solution;

    public function setSolution(Solution $solution): void
    {
        $this->solution = $solution;
    }

    public function getSolution(): Solution
    {
        return $this->solution;
    }
}
