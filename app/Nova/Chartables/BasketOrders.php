<?php

declare(strict_types=1);

namespace App\Nova\Chartables;

use App\Models\Shop\ShopOrder;
use Carbon\Carbon;
use Jpeters8889\ApexCharts\Chartable;
use Jpeters8889\ApexCharts\DTO\DateRange;

class BasketOrders extends Chartable
{
    public function type(): string
    {
        return static::LINE_CHART;
    }

    public function name(): string
    {
        return 'Baskets vs Orders';
    }

    public function getData(Carbon $startDate, Carbon $endDate): array
    {
        return [
            ShopOrder::query()
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->count(),

            ShopOrder::query()
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->whereNotNull('order_key')->count(),
        ];
    }

    public function defaultDateRange(): string
    {
        return self::DATE_RANGE_PAST_2_WEEKS;
    }

    protected function data(DateRange $dateRange): array
    {
        $data = $this->calculateData($dateRange);

        $baskets = array_map(fn (array $a) => $a[0], $data);
        $sales = array_map(fn (array $a) => $a[1], $data);

        return [
            [
                'name' => 'Baskets',
                'data' => $baskets,
                'color' => '#80CCFC',
            ],
            [
                'name' => 'Sales',
                'data' => $sales,
                'color' => '#DBBC25',
            ],
        ];
    }
}
