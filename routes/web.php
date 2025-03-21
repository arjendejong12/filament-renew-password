<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::name('filament.')->group(function () {
    foreach (Filament::getPanels() as $panel) {
        $domains = $panel->getDomains();

        foreach ((empty($domains) ? [null] : $domains) as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name($panel->getId() . '.')
                ->prefix($panel->getPath())
                ->group(function () use ($panel) {
                    if ($panel->hasPlugin('filament-renew-password')) {
                        $plugin = $panel->getPlugin('filament-renew-password');
                        Route::get($plugin->getRouteUri(), $plugin->getRenewPage())->name('auth.password.renew');
                    }
                });
        }
    }
});
