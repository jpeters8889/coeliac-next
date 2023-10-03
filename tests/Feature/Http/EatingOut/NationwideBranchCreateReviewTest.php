<?php

declare(strict_types=1);

namespace Tests\Feature\Http\EatingOut;

use App\Models\EatingOut\NationwideBranch;
use Tests\RequestFactories\EateryCreateReviewRequestFactory;

class NationwideBranchCreateReviewTest extends NationwideCreateReviewTest
{
    protected NationwideBranch $nationwideBranch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->county->update(['county' => 'Nationwide']);
        $this->town->update(['town' => 'nationwide']);

        $this->nationwideBranch = $this->create(NationwideBranch::class, [
            'wheretoeat_id' => $this->eatery->id,
        ]);
    }

    protected function route(string $county = null, string $town = null, string $eatery = null): string
    {
        return route('eating-out.nationwide.show.branch.reviews.create', [
            'eatery' => $eatery ?? $this->eatery->slug,
            'nationwideBranch' => $this->nationwideBranch->slug,
        ]);
    }

    protected function data(array $data = []): EateryCreateReviewRequestFactory
    {
        $request = EateryCreateReviewRequestFactory::new($data);

        if ( ! array_key_exists('nationwide_branch', $data)) {
            $request = $request->forBranch();
        }

        return $request;
    }

    /** @test */
    public function itErrorsWithoutABranchNameWhenTheEateryIsNationwide(): void
    {
        $this->submitForm(EateryCreateReviewRequestFactory::new(['branch_name' => 123])->create())
            ->assertSessionHasErrors('branch_name');

        $this->submitForm(EateryCreateReviewRequestFactory::new(['branch_name' => false])->create())
            ->assertSessionHasErrors('branch_name');
    }
}
