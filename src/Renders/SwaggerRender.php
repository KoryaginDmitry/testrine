<?php

declare(strict_types=1);

namespace DkDev\Testrine\Renders;

use DkDev\Testrine\Support\Infrastructure\Config;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class SwaggerRender extends BaseRender
{
    public function render(): Factory|Application|View
    {
        return view('swagger-ui.index', [
            'url' => route(
                Config::getDocsValue('routes.scheme.name')
            ),
        ]);
    }
}
