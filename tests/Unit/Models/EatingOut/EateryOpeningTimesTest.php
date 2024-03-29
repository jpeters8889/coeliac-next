<?php

declare(strict_types=1);

namespace Tests\Unit\Models\EatingOut;

use App\Models\EatingOut\EateryOpeningTimes;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class EateryOpeningTimesTest extends TestCase
{
    /** @test */
    public function itReturnsAnIsOpenAttribute(): void
    {
        $openingTime = $this->create(EateryOpeningTimes::class);

        $this->assertIsBool($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsNotOpenIfThereIsNoOpeningTimesForTheGivenDay(): void
    {
        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, ["{$today}_start" => null]);

        $this->assertFalse($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsClosedIfBeforeOpeningTimes(): void
    {
        TestTime::freeze()->startOfHour();

        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, ["{$today}_start" => '12:00']);

        TestTime::setHour(10);

        $this->assertFalse($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsClosedIfAfterOpeningTimes(): void
    {
        TestTime::freeze()->startOfHour();

        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, ["{$today}_end" => '17:00']);

        TestTime::setHour(18);

        $this->assertFalse($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsOpenIfBetweenOpeningTimes(): void
    {
        TestTime::freeze()->startOfHour();

        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, [
            "{$today}_start" => '10:00',
            "{$today}_end" => '17:00',
        ]);

        TestTime::setHour(12);

        $this->assertTrue($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsOpenIfBetweenOpeningTimesThatArentHours(): void
    {
        TestTime::freeze()->startOfHour();

        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, [
            "{$today}_start" => '16:45',
            "{$today}_end" => '17:15',
        ]);

        TestTime::setHour(17)->setMinute(0);

        $this->assertTrue($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsOpenWhenClosingTimeIsAtMidnight(): void
    {
        TestTime::freeze()->startOfHour();

        $today = Str::lower(Carbon::now()->dayName);

        $openingTime = $this->create(EateryOpeningTimes::class, [
            "{$today}_start" => '22:00',
            "{$today}_end" => '00:00',
        ]);

        TestTime::setHour(23);

        $this->assertTrue($openingTime->is_open_now);
    }
}
