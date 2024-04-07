<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopRemoveDiscountCodeController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->session()->remove('discountCode');

        return redirect()->back();
    }
}
