<?php

declare(strict_types=1);

namespace App\Nova\Actions\EatingOut;

use App\Models\Comments\Comment;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReplyToCommentComment extends Action
{
    public $name = 'Approve';

    public $withoutActionEvents = true;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Comment $comment) use ($fields): void {
            if ($comment->approved) {
                return;
            }

            $comment->reply()->create([
                'comment_reply' => $fields->reply,
            ]);

            $comment->update(['approved' => true]);

            // @todo
            //            (new AnonymousNotifiable())
            //                ->route('mail', $review->email)
            //                ->notify(new WhereToEatRatingApprovedNotification($rating));
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Textarea::make('Reply'),
        ];
    }
}
