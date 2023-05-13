<?php

declare(strict_types=1);

namespace App\Providers;

use App\Nova\Resources\Main\Blog;
use App\Nova\Resources\Main\BlogTag;
use App\Nova\Resources\Main\Collection;
use App\Nova\Resources\Main\CollectionItem;
use App\Nova\Resources\Main\Recipe;
use App\Nova\Resources\Main\RecipeAllergens;
use App\Nova\Resources\Main\RecipeNutritionalInformation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Jpeters8889\AdvancedNovaMediaLibrary\AdvancedNovaMediaLibraryServiceProvider;
use Jpeters8889\Body\FieldServiceProvider as BodyFieldServiceProvider;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Jpeters8889\PolymorphicPanel\FieldServiceProvider as PolymorphicPanelFieldServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function resources(): void
    {
        Nova::resources([
            Blog::class,
            BlogTag::class,
            Collection::class,
            CollectionItem::class,
            Recipe::class,
            RecipeAllergens::class,
            RecipeNutritionalInformation::class,
        ]);
    }

    /** @return class-string<ServiceProvider>[]  */
    protected function fields(): array
    {
        return [
            AdvancedNovaMediaLibraryServiceProvider::class,
            BodyFieldServiceProvider::class,
            PolymorphicPanelFieldServiceProvider::class,
        ];
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
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
            new \App\Nova\Dashboards\Main(),
        ];
    }

    public function register(): void
    {
        foreach ($this->fields() as $field) {
            $this->app->register($field);
        }

        Field::macro('deferrable', function () {
            $this->deferrable = true; /** @phpstan-ignore-line */

            return $this;
        });
    }
}
