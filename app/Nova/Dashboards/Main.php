<?php

declare(strict_types=1);

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Comments;
use App\Nova\Metrics\PlaceRequests;
use App\Nova\Metrics\Ratings;
use Jpeters8889\ApexCharts\ApexChart;
use Laravel\Nova\Dashboards\Main as Dashboard;

/**
 * @codeCoverageIgnore
 */
class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            Comments::make(),
            Ratings::make(),
            PlaceRequests::make(),
            //            EmailsSent::make(),
            ApexChart::make(\App\Nova\Chartables\EmailsSent::class)->fullWidth(),
            ApexChart::make(\App\Nova\Chartables\EateryRatings::class)->fullWidth(),
            //            EateryRatings::make(),
        ];
    }
}
