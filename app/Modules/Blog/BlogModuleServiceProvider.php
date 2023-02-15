<?php

declare(strict_types=1);

namespace App\Modules\Blog;

use App\Modules\Blog\Providers\RouteServiceProvider;
use App\Providers\ModuleBootstrapperServiceProvider;

class BlogModuleServiceProvider extends ModuleBootstrapperServiceProvider
{
    public function providers(): array
    {
        return [
            RouteServiceProvider::class,
        ];
    }
}
