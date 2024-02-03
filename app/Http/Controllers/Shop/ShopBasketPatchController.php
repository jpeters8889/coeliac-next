<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\Shop\AlterItemQuantityAction;
use App\Actions\Shop\ResolveBasketAction;
use App\Http\Requests\Shop\BasketPatchRequest;
use App\Models\Shop\ShopOrder;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ShopBasketPatchController
{
    public function __invoke(BasketPatchRequest $request, ResolveBasketAction $resolveBasketAction): RedirectResponse
    {
        /** @var string | null $token */
        $token = $request->cookies->get('basket_token');

        /** @var ShopOrder | null $basket */
        $basket = $resolveBasketAction->handle($token, false);

        if ( ! $basket) {
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            if ($request->has('postage_country_id')) {
                $basket->update([
                    'postage_country_id' => $request->integer('postage_country_id'),
                ]);
            }

            if ($request->has('action')) {
                $orderItem = $basket->items()->findOrFail($request->integer('item_id'));

                app(AlterItemQuantityAction::class)->handle($orderItem, $request->string('action')->toString());
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }

        return redirect()->back();
    }
}
