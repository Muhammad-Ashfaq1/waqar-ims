<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('permissions:sync {--seed-users}', function () {
    $this->call('app:sync-permissions', [
        '--seed-users' => $this->option('seed-users'),
    ]);
})->purpose('Synchronize roles and permissions');
