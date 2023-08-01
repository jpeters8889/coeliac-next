<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shared\Comments;

use App\Models\Comments\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\TestCase;

/** @mixin TestCase */
trait CommentableTestTrait
{
    /** @var callable(array $parameters): Model */
    protected $factoryClosure;

    /** @param callable(array $parameters): Model $factory */
    protected function setUpCommentsTest(callable $factory): void
    {
        $this->factoryClosure = $factory;
    }

    /** @test */
    public function itHasACommentsRelationship(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->assertInstanceOf(MorphMany::class, $item->comments());
    }

    /** @test */
    public function itHasAnAllCommentsRelationship(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->assertInstanceOf(MorphMany::class, $item->allComments());
    }

    /** @test */
    public function commentsAreNotApprovedByDefault(): void
    {
        $item = call_user_func($this->factoryClosure);

        $comment = $this->build(Comment::class)->on($item)->create();

        $this->assertFalse($comment->approved);
    }

    /** @test */
    public function theCommentsRelationshipDoesntReturnCommentsThatAreNotApproved(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->build(Comment::class)->on($item)->create();

        $this->assertCount(0, $item->fresh()->comments);
    }

    /** @test */
    public function theAllCommentsRelationshipReturnsCommentsThatAreNotApproved(): void
    {
        $item = call_user_func($this->factoryClosure);

        $this->build(Comment::class)->on($item)->create();

        $this->assertCount(1, $item->fresh()->allComments);
    }
}
