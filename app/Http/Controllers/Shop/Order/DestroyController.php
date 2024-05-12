<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop\Order;

use App\Enums\Shop\OrderState;
use App\Models\Shop\ShopOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DestroyController
{
    public function __invoke(Request $request): Response
    {
        /** @var string | null $token */
        $token = $request->cookies->get('basket_token');

        if ($token) {
            ShopOrder::query()
                ->where('token', $token)
                ->where('state_id', OrderState::PENDING)
                ->update(['state_id' => OrderState::BASKET]);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
