<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule our custom scheduled post publishing command to run every 5 minutes
Schedule::command('posts:publish-due')->everyFiveMinutes();
