<?php

declare(strict_types=1);

namespace Jpeters8889\ApexCharts\DTO;

use Carbon\Carbon;

readonly class DateRange
{
    public function __construct(
        public string $label,
        public Carbon $startDate,
        public Carbon $endDate,
        public string $unit,
        public string $dateFormat,
    ) {
        //
    }
}
