<?php

use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\StorageHelper;
use Illuminate\Support\Facades\Route;

Route::middleware(Config::getSwaggerValue('routes.middlewares'))
    ->group(function () {

        Route::get(Config::getSwaggerValue('routes.ui.path'), function () {
            return view('swagger-ui.index', [
                'url' => route(
                    Config::getSwaggerValue('routes.scheme.name')
                ),
            ]);
        })
            ->middleware(Config::getSwaggerValue('routes.ui.middlewares'))
            ->name(Config::getSwaggerValue('routes.ui.name'));

        Route::get(Config::getSwaggerValue('routes.scheme.path'), function () {
            return StorageHelper::driver()->json(
                Config::getSwaggerValue('storage.docs.path').Config::getSwaggerValue('storage.docs.name').'.json'
            );
        })
            ->middleware(Config::getSwaggerValue('routes.scheme.middlewares'))
            ->name(Config::getSwaggerValue('routes.scheme.name'));
    });
