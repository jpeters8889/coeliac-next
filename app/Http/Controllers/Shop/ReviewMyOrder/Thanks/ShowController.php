<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\ReviewMyOrder\Thanks;

use App\Http\Response\Inertia;
use App\Models\Shop\ShopOrderReviewInvitation;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ShowController
{
    public function __invoke(Inertia $inertia, ShopOrderReviewInvitation $invitation): RedirectResponse|Response
    {
        abort_if( ! $invitation->review()->exists(), 404);

        return $inertia
            ->title('Thanks!')
            ->doNotTrack()
            ->render('Shop/ReviewMyOrderThanks');
    }
}
