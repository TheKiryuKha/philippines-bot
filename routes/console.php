<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::daily()
    ->onOneServer()
    ->timezone('Asia/Manila')
    ->group(function () {
        Schedule::command('check-visas');
    });
