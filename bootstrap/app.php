<?php

declare(strict_types=1);

use App\Console\Commands\ApplyMassDiscountsCommand;
use App\Console\Commands\CloseBasketsCommand;
use App\Console\Commands\PrepareShopReviewInvitationsCommand;
use App\Console\Commands\PublishItemsCommand;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        health: '/up',
        then: function (): void {
            if (config('app.env') === 'local') {
                Route::middleware('web')
                    ->prefix('__dev')
                    ->group(base_path('routes/local.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: HandleInertiaRequests::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command(CloseBasketsCommand::class)->everyMinute();
        $schedule->command(ApplyMassDiscountsCommand::class)->everyMinute();
        $schedule->command(PrepareShopReviewInvitationsCommand::class)->everyMinute();
        $schedule->command(PublishItemsCommand::class)->everyMinute();
    })
    ->create();
