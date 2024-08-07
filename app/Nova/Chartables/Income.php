<?php

declare(strict_types=1);

namespace App\Nova\Chartables;

use App\Models\Shop\ShopOrder;
use Carbon\Carbon;
use Jpeters8889\ApexCharts\Chartable;

class Income extends Chartable
{
    public function type(): string
    {
        return static::LINE_CHART;
    }

    public function getData(Carbon $startDate, Carbon $endDate): int|float
    {
        $total = 0;

        ShopOrder::query()
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->whereNotNull('order_key')
            ->with('payment')
            ->get()
            ->map(function (ShopOrder $order) use (&$total): void {
                $total += $order->payment?->total;
            });

        return $total / 100;
    }

    public function defaultDateRange(): string
    {
        return self::DATE_RANGE_PAST_YEAR;
    }
}
