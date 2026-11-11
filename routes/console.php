<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| INSPIRE COMMAND
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|--------------------------------------------------------------------------
| SIX-YEAR OBT AND BS COMPLIANCE MONITORING
|--------------------------------------------------------------------------
|
| Automatically checks cadets who have reached six years
| since their account registration date.
|
*/

Schedule::command('obt:check-six-year-compliance')
    ->dailyAt('08:00')
    ->withoutOverlapping();

    // Check cadet insurance expiration every day at 8:10 AM Manila time.
Schedule::command('obt:check-insurance-expiration')
    ->dailyAt('08:10')
    ->timezone('Asia/Manila')
    ->withoutOverlapping();
