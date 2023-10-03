<?php

declare(strict_types=1);

namespace Tests\Feature\Http\EatingOut;

use Tests\RequestFactories\EateryCreateReviewRequestFactory;

class NationwideCreateReviewTest extends EateryCreateReviewTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->county->update(['county' => 'Nationwide']);
        $this->town->update(['town' => 'nationwide']);
    }

    protected function route(string $county = null, string $town = null, string $eatery = null): string
    {
        return route('eating-out.nationwide.show.reviews.create', [
            'eatery' => $eatery ?? $this->eatery->slug,
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
