<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Newsletter;

use App\Actions\SignUpToNewsletterAction;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    #[Test]
    public function itErrorsWithoutAnEmail(): void
    {
        $this->post(route('newsletter.store'))->assertSessionHasErrors('email');
    }

    #[Test]
    public function itErrorsWithAnInvalidEmailAddress(): void
    {
        $this->post(route('newsletter.store'), ['email' => 'foo'])->assertSessionHasErrors('email');
    }

    #[Test]
    public function itCallsTheSignUpToNewsletterAction(): void
    {
        $this->expectAction(SignUpToNewsletterAction::class);

        $this->post(route('newsletter.store'), ['email' => 'foo@bar.com']);
    }

    #[Test]
    public function itRedirectsBack(): void
    {
        $this->expectAction(SignUpToNewsletterAction::class);

        $this
            ->from(route('about'))
            ->post(route('newsletter.store'), ['email' => 'foo@bar.com'])
            ->assertRedirectToRoute('about');
    }
}
