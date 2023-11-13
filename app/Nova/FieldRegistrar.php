<?php

declare(strict_types=1);

namespace App\Nova;

use Jpeters8889\AddressField\FieldServiceProvider as AddressFieldServiceProvider;
use Jpeters8889\AdvancedNovaMediaLibrary\AdvancedNovaMediaLibraryServiceProvider;
use Jpeters8889\Body\FieldServiceProvider as BodyFieldServiceProvider;
use Jpeters8889\EateryOpeningTimes\FieldServiceProvider as EateryOpeningTimesFieldServiceProvider;
use Jpeters8889\PolymorphicPanel\FieldServiceProvider as PolymorphicPanelFieldServiceProvider;

class FieldRegistrar
{
    public static function handle(): void
    {
        $customFields = [
            AddressFieldServiceProvider::class,
            AdvancedNovaMediaLibraryServiceProvider::class,
            BodyFieldServiceProvider::class,
            EateryOpeningTimesFieldServiceProvider::class,
            PolymorphicPanelFieldServiceProvider::class,
        ];

        foreach ($customFields as $customField) {
            app()->register($customField);
        }
    }
}
