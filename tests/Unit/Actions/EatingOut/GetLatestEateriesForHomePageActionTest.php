<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\EatingOut;

use App\Actions\EatingOut\GetLatestEateriesForHomepageAction;
use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use App\Resources\EatingOut\SimpleEateryResource;
use Carbon\Carbon;
use Database\Seeders\EateryScaffoldingSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GetLatestEateriesForHomePageActionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(EateryScaffoldingSeeder::class);
    }

    /** @test */
    public function itCanReturnACollectionOfEateries(): void
    {
        $this->assertInstanceOf(AnonymousResourceCollection::class, $this->callAction(GetLatestEateriesForHomepageAction::class));
    }

    /** @test */
    public function itOnlyReturnsTheEateriesAsASimpleEateryResource(): void
    {
        $this->build(Eatery::class)->count(5)->create();

        $this->callAction(GetLatestEateriesForHomepageAction::class)->each(function ($item): void {
            $this->assertInstanceOf(SimpleEateryResource::class, $item);
        });
    }

    /** @test */
    public function itReturnsEightEateries(): void
    {
        $this->build(Eatery::class)->count(10)->create();

        $this->assertCount(8, $this->callAction(GetLatestEateriesForHomepageAction::class));
    }

    /** @test */
    public function itReturnsTheLatestEateriesFirst(): void
    {
        $this->build(Eatery::class)
            ->count(10)
            ->sequence(fn (Sequence $sequence) => [
                'id' => $sequence->index + 1,
                'name' => "Eatery {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index),
            ])
            ->create();

        $eateryNames = $this->callAction(GetLatestEateriesForHomepageAction::class)->map(fn (SimpleEateryResource $eatery) => $eatery->name);

        $this->assertContains('Eatery 0', $eateryNames);
        $this->assertContains('Eatery 1', $eateryNames);
        $this->assertNotContains('Eatery 9', $eateryNames);
    }

    /** @test */
    public function itDoesntReturnEateriesThatArentLive(): void
    {
        $this->build(Eatery::class)
            ->count(10)
            ->sequence(fn (Sequence $sequence) => [
                'live' => $sequence->index === 0 ? false : true,
                'id' => $sequence->index + 1,
                'name' => "Eatery {$sequence->index}",
                'created_at' => Carbon::now()->subDays($sequence->index),
            ])
            ->create();

        $eateryNames = $this->callAction(GetLatestEateriesForHomepageAction::class)->map(fn (SimpleEateryResource $eatery) => $eatery->name);

        $this->assertNotContains('Eatery 0', $eateryNames);
        $this->assertContains('Eatery 2', $eateryNames);
    }

    /** @test */
    public function itAlsoReturnsNationwideBranches(): void
    {
        $this->build(NationwideBranch::class)->count(5)->create();

        $this->callAction(GetLatestEateriesForHomepageAction::class)->each(function ($item): void {
            $this->assertInstanceOf(SimpleEateryResource::class, $item);
        });
    }

    /** @test */
    public function itCachesTheEateries(): void
    {
        $this->assertFalse(Cache::has(config('coeliac.cache.eating-out.home')));

        $eateries = $this->callAction(GetLatestEateriesForHomepageAction::class);

        $this->assertTrue(Cache::has(config('coeliac.cache.eating-out.home')));
        $this->assertSame($eateries, Cache::get(config('coeliac.cache.eating-out.home')));
    }

    /** @test */
    public function itLoadsTheBlogsFromTheCache(): void
    {
        DB::enableQueryLog();

        $this->callAction(GetLatestEateriesForHomepageAction::class);

        $this->assertCount(2, DB::getQueryLog());

        $this->callAction(GetLatestEateriesForHomepageAction::class);

        $this->assertCount(2, DB::getQueryLog());
    }
}
