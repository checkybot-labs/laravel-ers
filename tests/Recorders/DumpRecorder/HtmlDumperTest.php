<?php

use CheckybotLabs\LaravelErs\Recorders\DumpRecorder\HtmlDumper;

it('has an empty string as dump header', function () {
    $dumpHeader = (fn () => $this->getDumpHeader())->call(new HtmlDumper);

    expect($dumpHeader)->toBe('');
});
