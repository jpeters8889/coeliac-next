<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\ApplyMassDiscountsCommand;
use App\Console\Commands\CleanUpOldProductPricesCommand;
use App\Console\Commands\CloseBasketsCommand;
use App\Console\Commands\GetCountyLatLngCommand;
use App\Console\Commands\GetTownLatLngCommand;
use App\Console\Commands\MigrateImagesToMedia;
use App\Console\Commands\PrepareShopReviewInvitationsCommand;
use App\Console\Commands\PublishItemsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        GetCountyLatLngCommand::class,
        GetTownLatLngCommand::class,
        MigrateImagesToMedia::class,
        CleanUpOldProductPricesCommand::class,
        CloseBasketsCommand::class,
        ApplyMassDiscountsCommand::class,
        PrepareShopReviewInvitationsCommand::class,
        PublishItemsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CloseBasketsCommand::class)->everyMinute();
        $schedule->command(ApplyMassDiscountsCommand::class)->everyMinute();
        $schedule->command(PrepareShopReviewInvitationsCommand::class)->everyMinute();
        $schedule->command(PublishItemsCommand::class)->everyMinute();
    }
}
