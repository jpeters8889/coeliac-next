<?php

declare(strict_types=1);

namespace App\Nova\Actions\EatingOut;

use App\Models\EatingOut\EateryRecommendation;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

/**
 * @codeCoverageIgnore
 */
class ConvertRecommendationToEatery extends Action
{
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var EateryRecommendation $recommendation */
        $recommendation = $models->first();

        $recommendation->update(['completed' => true]);

        return Action::visit('/resources/eateries/new', array_filter([
            'place_name' => $recommendation->place_name,
            'place_location' => $recommendation->place_location,
            'place_web_address' => $recommendation->place_web_address,
            'place_venue_type_id' => $recommendation->place_venue_type_id,
            'place_details' => $recommendation->place_details,
        ]));
    }
}
