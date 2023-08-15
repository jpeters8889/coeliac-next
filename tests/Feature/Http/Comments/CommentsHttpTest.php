<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Comments;

use App\Models\Blogs\Blog;
use App\Models\Comments\Comment;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\CommentRequestFactory;
use Tests\TestCase;

class CommentsHttpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withBlogs(2);
    }

    protected function createComment(array $parameters = []): TestResponse
    {
        return $this->post(route('comments.create'), CommentRequestFactory::new()->create($parameters));
    }

    /** @test */
    public function itErrorsWithoutAModule(): void
    {
        $this->createComment(['module' => null])->assertSessionHasErrors('module');
    }

    /** @test */
    public function itErrorsIfTheModuleDoesNotExist(): void
    {
        $this->createComment(['module' => 'foo'])->assertSessionHasErrors('module');
    }

    /** @test */
    public function itErrorsWithoutAnId(): void
    {
        $this->createComment(['id' => null])->assertSessionHasErrors('id');
    }

    /** @test */
    public function itErrorsWithANonNumericId(): void
    {
        $this->createComment(['id' => 'foo'])->assertSessionHasErrors('id');
    }

    /** @test */
    public function itErrorsWithAnIdThatDoesntExist(): void
    {
        $this->createComment(['id' => 999])->assertSessionHasErrors('id');
    }

    /** @test */
    public function itErrorsWithAnIdOfAnItemThatIsntLive(): void
    {
        Blog::query()->find(2)->update(['live' => false]);

        $this->createComment(['id' => 2])->assertSessionHasErrors('id');
    }

    /** @test */
    public function itErrorsWithOutAName(): void
    {
        $this->createComment(['name' => null])->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsWithAnInvalidName(): void
    {
        $this->createComment(['name' => 123])->assertSessionHasErrors('name');
    }

    /** @test */
    public function itErrorsWithOutAnEmail(): void
    {
        $this->createComment(['email' => null])->assertSessionHasErrors('email');
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail(): void
    {
        $this->createComment(['email' => 123])->assertSessionHasErrors('email');
        $this->createComment(['email' => 'foo'])->assertSessionHasErrors('email');
    }

    /** @test */
    public function itErrorsWithOutAComment(): void
    {
        $this->createComment(['comment' => null])->assertSessionHasErrors('comment');
    }

    /** @test */
    public function itDoesntReturnAnyErrorsWithASuccessfulRequest(): void
    {
        $this->createComment()->assertSessionDoesntHaveErrors();
    }

    /** @test */
    public function itCreatesTheComment(): void
    {
        $this->assertEmpty(Comment::query()->get());

        $this->createComment();

        $this->assertNotEmpty(Comment::query()->get());
        $this->assertNotEmpty(Blog::query()->first()->allComments);
    }

    /** @test */
    public function commentsAreNotApprovedByDefault(): void
    {
        $this->createComment();

        $comment = Comment::query()->first();

        $this->assertFalse($comment->approved);
    }

    /** @test */
    public function itStoresTheCommentsDetails(): void
    {
        $this->createComment([
            'name' => 'Foo Bar',
            'email' => 'me@you.com',
            'comment' => 'Hello There!',
        ]);

        /** @var Comment $comment */
        $comment = Comment::query()->first();

        $this->assertEquals('Foo Bar', $comment->name);
        $this->assertEquals('me@you.com', $comment->email);
        $this->assertEquals('Hello There!', $comment->comment);
    }

    /** @test */
    public function itRedirectsBack(): void
    {
        $this->createComment()->assertRedirect();
    }
}
