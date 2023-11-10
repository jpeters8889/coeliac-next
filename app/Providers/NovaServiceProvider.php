<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\EatingOut\EateryRecommendation;
use App\Models\EatingOut\EateryReview;
use App\Nova\Dashboards\Main;
use App\Nova\Resources\EatingOut\Counties;
use App\Nova\Resources\EatingOut\Countries;
use App\Nova\Resources\EatingOut\Eateries;
use App\Nova\Resources\EatingOut\MyPlaces;
use App\Nova\Resources\EatingOut\NationwideBranches;
use App\Nova\Resources\EatingOut\NationwideEateries;
use App\Nova\Resources\EatingOut\ReviewImage;
use App\Nova\Resources\EatingOut\Reviews;
use App\Nova\Resources\EatingOut\Towns;
use App\Nova\Resources\Main\Blog;
use App\Nova\Resources\Main\BlogTag;
use App\Nova\Resources\Main\Collection;
use App\Nova\Resources\Main\CollectionItem;
use App\Nova\Resources\Main\Recipe;
use App\Nova\Resources\Main\RecipeAllergens;
use App\Nova\Resources\Main\RecipeNutritionalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Jpeters8889\AddressField\FieldServiceProvider as AddressFieldServiceProvider;
use Jpeters8889\AdvancedNovaMediaLibrary\AdvancedNovaMediaLibraryServiceProvider;
use Jpeters8889\Body\FieldServiceProvider as BodyFieldServiceProvider;
use Jpeters8889\EateryOpeningTimes\FieldServiceProvider as EateryOpeningTimesFieldServiceProvider;
use Jpeters8889\PolymorphicPanel\FieldServiceProvider as PolymorphicPanelFieldServiceProvider;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function resources(): void
    {
        Nova::resources([
            // Main
            Blog::class,
            BlogTag::class,
            Collection::class,
            CollectionItem::class,
            Recipe::class,
            RecipeAllergens::class,
            RecipeNutritionalInformation::class,

            // Eating Out
            Eateries::class,
            NationwideEateries::class,
            NationwideBranches::class,
            Countries::class,
            Counties::class,
            Towns::class,
            Reviews::class,
            ReviewImage::class,
            MyPlaces::class,
        ]);
    }

    public function boot(): void
    {
        parent::boot();

        Nova::withBreadcrumbs();

        $reviewCount = EateryReview::withoutGlobalScopes()->where('approved', false)->count();
        $myPlacesCount = EateryRecommendation::query()->where('email', 'contact@coeliacsanctuary.co.uk')->where('completed', false)->count();

        Nova::mainMenu(fn (Request $request) => [
            MenuSection::make('Dashboards', [
                MenuItem::dashboard(Main::class),
            ])->icon('chart-bar'),

            MenuSection::make('Main Site', [
                MenuItem::resource(Blog::class),
                MenuItem::resource(Recipe::class),
                MenuItem::resource(Collection::class),
            ])->icon('home'),

            MenuSection::make('Eating Out', [
                MenuGroup::make('Locations', [
                    MenuItem::resource(Eateries::class),
                    MenuItem::resource(NationwideEateries::class),
                    MenuItem::resource(Counties::class),
                    MenuItem::resource(Towns::class),
                ]),

                MenuGroup::make('Feedback', [
                    MenuItem::resource(Reviews::class)
                        ->withBadgeIf(fn () => $reviewCount, 'danger', fn () => $reviewCount > 0),
                ]),

                MenuGroup::make('Recommendations', [
                    MenuItem::resource(MyPlaces::class)
                        ->withBadgeIf(fn () => $myPlacesCount, 'danger', fn () => $myPlacesCount > 0),
                ]),
            ])->icon('map'),
        ]);
    }

    /** @return class-string<ServiceProvider>[] */
    protected function fields(): array
    {
        return [
            AddressFieldServiceProvider::class,
            AdvancedNovaMediaLibraryServiceProvider::class,
            BodyFieldServiceProvider::class,
            EateryOpeningTimesFieldServiceProvider::class,
            PolymorphicPanelFieldServiceProvider::class,
        ];
    }

    /**
     * Register the Nova routes.
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
            new Main(),
        ];
    }

    public function register(): void
    {
        AddressFieldServiceProvider::setGoogleApiKey(config('services.google.maps.admin'));

        foreach ($this->fields() as $field) {
            $this->app->register($field);
        }

        Field::macro('deferrable', function () {
            /** @phpstan-ignore-next-line */
            $this->deferrable = true;

            return $this;
        });
    }
}
