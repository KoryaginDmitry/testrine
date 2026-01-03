<?php

use DkDev\Testrine\Renders\BaseRender;
use DkDev\Testrine\Support\Infrastructure\Config;
use DkDev\Testrine\Support\Infrastructure\StorageHelper;
use Illuminate\Support\Facades\Route;

Route::middleware(Config::getDocsValue('routes.middlewares'))
    ->group(function () {

        Route::get(Config::getDocsValue('routes.ui.path'), function (BaseRender $render) {
            return $render->render();
        })
            ->middleware(Config::getDocsValue('routes.ui.middlewares'))
            ->name(Config::getDocsValue('routes.ui.name'));

        Route::get(Config::getDocsValue('routes.scheme.path'), function () {
            return StorageHelper::driver()->json(
                Config::getDocsValue('storage.docs.path').Config::getDocsValue('storage.docs.name').'.json'
            );
        })
            ->middleware(Config::getDocsValue('routes.scheme.middlewares'))
            ->name(Config::getDocsValue('routes.scheme.name'));
    });
