<?php

declare(strict_types=1);

namespace Tests\Concerns;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Comments\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\TestCase;

/** @mixin TestCase */
trait CommentableTestTrait
{
    /** @var callable(array): Model */
    protected $factoryClosure;

    /** @param  callable(array $parameters): Model  $factory */
    protected function setUpCommentsTest(callable $factory): void
    {
        $this->factoryClosure = $factory;
    }

    #[Test]
    public function itHasACommentsRelationship(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->assertInstanceOf(MorphMany::class, $item->comments());
    }

    #[Test]
    public function itHasAnAllCommentsRelationship(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->assertInstanceOf(MorphMany::class, $item->allComments());
    }

    #[Test]
    public function commentsAreNotApprovedByDefault(): void
    {
        $item = call_user_func($this->factoryClosure);

        $comment = $this->build(Comment::class)->on($item)->create();

        $this->assertFalse($comment->approved);
    }

    #[Test]
    public function theCommentsRelationshipDoesntReturnCommentsThatAreNotApproved(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->build(Comment::class)->on($item)->create();

        $this->assertCount(0, $item->fresh()->comments);
    }

    #[Test]
    public function theAllCommentsRelationshipReturnsCommentsThatAreNotApproved(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->build(Comment::class)->on($item)->create();

        $this->assertCount(1, $item->fresh()->allComments);
    }
}
