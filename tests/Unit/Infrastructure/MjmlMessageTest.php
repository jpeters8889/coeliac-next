<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure;

use App\Infrastructure\MjmlMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\TestCase;

class MjmlMessageTest extends TestCase
{
    /** @test */
    public function itExtendsTheMailMessage(): void
    {
        $instance = new MjmlMessage();

        $this->assertInstanceOf(MailMessage::class, $instance);
    }

    /** @test */
    public function itHasAStaticConstructor(): void
    {
        $this->assertInstanceOf(
            MjmlMessage::class,
            MjmlMessage::make(),
        );
    }

    /** @test */
    public function itCanSetAViewAndDataFromTheStaticConstructor(): void
    {
        $instance = MjmlMessage::make('test-view', ['foo' => 'bar']);

        $this->assertEquals('test-view', $instance->mjml);
        $this->assertEquals(['foo' => 'bar'], $instance->viewData);
    }

    /** @test */
    public function itCanSetTheViewAndDataFromAnMjmlMethod(): void
    {
        $instance = new MjmlMessage();

        $instance->mjml('test-view', ['foo' => 'bar']);

        $this->assertEquals('test-view', $instance->mjml);
        $this->assertEquals(['foo' => 'bar'], $instance->viewData);
    }

    /** @test */
    public function itIsSentViaTheMailChannel(): void
    {
        $instance = MjmlMessage::make('test-view', ['foo' => 'bar']);

        $this->assertCount(1, $instance->via());
        $this->assertEquals(['mail'], $instance->via());
    }
}
