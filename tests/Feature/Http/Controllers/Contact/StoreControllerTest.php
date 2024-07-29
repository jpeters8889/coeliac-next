<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Contact;

use App\Events\ContactFormSubmittedEvent;
use Illuminate\Support\Facades\Event;
use Tests\RequestFactories\ContactRequestFactory;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    /** @test */
    public function itErrorsWithAnInvalidName(): void
    {
        $this->post(route('contact.store'), ContactRequestFactory::new(['name' => null])->create())
            ->assertSessionHasErrors('name');

        $this->post(route('contact.store'), ContactRequestFactory::new(['name' => 123])->create())
            ->assertSessionHasErrors('name');

        $this->post(route('contact.store'), ContactRequestFactory::new(['name' => true])->create())
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail(): void
    {
        $this->post(route('contact.store'), ContactRequestFactory::new(['email' => null])->create())
            ->assertSessionHasErrors('email');

        $this->post(route('contact.store'), ContactRequestFactory::new(['email' => 123])->create())
            ->assertSessionHasErrors('email');

        $this->post(route('contact.store'), ContactRequestFactory::new(['email' => true])->create())
            ->assertSessionHasErrors('email');

        $this->post(route('contact.store'), ContactRequestFactory::new(['email' => 'foo'])->create())
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function itErrorsWithAnInvalidSubject(): void
    {
        $this->post(route('contact.store'), ContactRequestFactory::new(['subject' => null])->create())
            ->assertSessionHasErrors('subject');

        $this->post(route('contact.store'), ContactRequestFactory::new(['subject' => 123])->create())
            ->assertSessionHasErrors('subject');

        $this->post(route('contact.store'), ContactRequestFactory::new(['subject' => true])->create())
            ->assertSessionHasErrors('subject');
    }

    /** @test */
    public function itErrorsWithAnInvalidMessage(): void
    {
        $this->post(route('contact.store'), ContactRequestFactory::new(['message' => null])->create())
            ->assertSessionHasErrors('message');

        $this->post(route('contact.store'), ContactRequestFactory::new(['message' => 123])->create())
            ->assertSessionHasErrors('message');

        $this->post(route('contact.store'), ContactRequestFactory::new(['message' => true])->create())
            ->assertSessionHasErrors('message');
    }

    /** @test */
    public function itDispatchesTheContactFormSubmittedEvent(): void
    {
        Event::fake();

        $this->post(route('contact.store'), ContactRequestFactory::new()->create())
            ->assertSessionHasNoErrors();

        Event::assertDispatched(ContactFormSubmittedEvent::class);
    }

    /** @test */
    public function itRedirectsBackToTheContactPage(): void
    {
        Event::fake();

        $this
            ->from(route('contact.index'))
            ->post(route('contact.store'), ContactRequestFactory::new()->create())
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('contact.index');
    }
}