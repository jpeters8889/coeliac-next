<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use PHPUnit\Framework\Attributes\Test;
use App\DataObjects\ContactFormData;
use App\Events\ContactFormSubmittedEvent;
use App\Listeners\SendContactFormListener;
use Tests\TestCase;

class ContactFormSubmittedEventTest extends TestCase
{
    #[Test]
    public function itIsHandledByTheSendContactFormListener(): void
    {
        $this->mock(SendContactFormListener::class)
            ->shouldReceive('handle')
            ->once();

        ContactFormSubmittedEvent::dispatch(new ContactFormData('foo', 'bar', 'baz', '123'));
    }
}
