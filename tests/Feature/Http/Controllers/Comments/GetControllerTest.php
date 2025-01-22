<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Comments;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Blogs\Blog;
use App\Models\Comments\Comment;
use Illuminate\Testing\TestResponse;
use Tests\RequestFactories\CommentRequestFactory;
use Tests\TestCase;

class GetControllerTest extends TestCase
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

    #[Test]
    public function itErrorsWithoutAModule(): void
    {
        $this->createComment(['module' => null])->assertSessionHasErrors('module');
    }

    #[Test]
    public function itErrorsIfTheModuleDoesNotExist(): void
    {
        $this->createComment(['module' => 'foo'])->assertSessionHasErrors('module');
    }

    #[Test]
    public function itErrorsWithoutAnId(): void
    {
        $this->createComment(['id' => null])->assertSessionHasErrors('id');
    }

    #[Test]
    public function itErrorsWithANonNumericId(): void
    {
        $this->createComment(['id' => 'foo'])->assertSessionHasErrors('id');
    }

    #[Test]
    public function itErrorsWithAnIdThatDoesntExist(): void
    {
        $this->createComment(['id' => 999])->assertSessionHasErrors('id');
    }

    #[Test]
    public function itErrorsWithAnIdOfAnItemThatIsntLive(): void
    {
        Blog::query()->find(2)->update(['live' => false]);

        $this->createComment(['id' => 2])->assertSessionHasErrors('id');
    }

    #[Test]
    public function itErrorsWithOutAName(): void
    {
        $this->createComment(['name' => null])->assertSessionHasErrors('name');
    }

    #[Test]
    public function itErrorsWithAnInvalidName(): void
    {
        $this->createComment(['name' => 123])->assertSessionHasErrors('name');
    }

    #[Test]
    public function itErrorsWithOutAnEmail(): void
    {
        $this->createComment(['email' => null])->assertSessionHasErrors('email');
    }

    #[Test]
    public function itErrorsWithAnInvalidEmail(): void
    {
        $this->createComment(['email' => 123])->assertSessionHasErrors('email');
        $this->createComment(['email' => 'foo'])->assertSessionHasErrors('email');
    }

    #[Test]
    public function itErrorsWithOutAComment(): void
    {
        $this->createComment(['comment' => null])->assertSessionHasErrors('comment');
    }

    #[Test]
    public function itDoesntReturnAnyErrorsWithASuccessfulRequest(): void
    {
        $this->createComment()->assertSessionDoesntHaveErrors();
    }

    #[Test]
    public function itCreatesTheComment(): void
    {
        $this->assertEmpty(Comment::query()->get());

        $this->createComment();

        $this->assertNotEmpty(Comment::query()->get());
        $this->assertNotEmpty(Blog::query()->first()->allComments);
    }

    #[Test]
    public function commentsAreNotApprovedByDefault(): void
    {
        $this->createComment();

        $comment = Comment::query()->first();

        $this->assertFalse($comment->approved);
    }

    #[Test]
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

    #[Test]
    public function itRedirectsBack(): void
    {
        $this->createComment()->assertRedirect();
    }
}
