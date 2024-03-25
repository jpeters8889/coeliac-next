<?php

declare(strict_types=1);

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\FieldRegistrar;
use App\Nova\Menu;
use App\Nova\NovaMacros;
use App\Nova\ResourceRegistrar;
use Illuminate\Support\Facades\Gate;
use Jpeters8889\AddressField\FieldServiceProvider as AddressFieldServiceProvider;
use Jpeters8889\OrderDispatchSlip\OrderDispatchSlip as DispatchSlipTool;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Nova::withBreadcrumbs();
        Nova::booted(function (): void {
            Menu::build();
        });
    }

    public function register(): void
    {
        AddressFieldServiceProvider::setGoogleApiKey(config('services.google.maps.admin'));

        FieldRegistrar::handle();
        NovaMacros::register();
    }

    protected function resources(): void
    {
        ResourceRegistrar::handle();
    }

    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            //            return in_array($user->email, [
            //                //
            //            ]);

            return true;
        });
    }

    protected function dashboards()
    {
        return [
            new Main(),
        ];
    }

    public function tools(): array
    {
        return [
            new DispatchSlipTool(),
        ];
    }
}
