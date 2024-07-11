<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api\EatingOut\Latest;

use App\Models\EatingOut\Eatery;
use App\Models\EatingOut\NationwideBranch;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /** @test */
    public function itReturnsTheLatestPlaces(): void
    {
        $eatery = $this->create(Eatery::class);

        $this->get(route('api.wheretoeat.latest'))->assertJsonFragment(['name' => $eatery->name]);
    }

    /** @test */
    public function itReturnsNationwideBranches(): void
    {
        $eatery = $this->create(Eatery::class);

        $branch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $eatery->id,
            'name' => 'foo',
        ]);

        $this->get(route('api.wheretoeat.latest'))->assertJsonFragment(['name' => "{$branch->name} - {$eatery->name}"]);
    }

    /** @test */
    public function itReturns5Results(): void
    {
        $this->build(Eatery::class)->count(10)->create();

        $this->get(route('api.wheretoeat.latest'))->assertJsonCount(5);
    }
}
