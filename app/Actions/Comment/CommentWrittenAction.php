<?php

namespace App\Actions\Comment;

use App\Actions\Achievement\AchievementUserVerify;
use App\Enums\AchievementType;
use App\Events\CommentWritten;
use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Console\Command;

class CommentWrittenAction
{
    use AsAction;

    /**
     * @var string
     */
    public string $commandSignature = 'comment:written';

    /**
     * @param Comment $comment
     *
     * @return void
     */
    public function handle(Comment $comment): void
    {
        $totalCommentsByTheUser = $comment->user->comments->count();

        AchievementUserVerify::dispatch($comment->user, $totalCommentsByTheUser, AchievementType::COMMENT->value);
    }

    /**
     * @param CommentWritten $event
     *
     * @return void
     */
    public function asListener(CommentWritten $event): void
    {
        $this->handle($event->comment);
    }

    /**
     * @param Command $command
     */
    public function asCommand(Command $command)
    {
        $userId = $command->ask('Give the User ID', 1);

        if (!is_numeric($userId) || !$user = User::find($userId)) {
            return $command->error('User not found.');
        }

        $body = $command->ask('Give the Comment', 'Test Comment');

        if (!$body) {
            return $command->error('Provide a comment.');
        }

        $comment = $user->comments()->create([
            'body' => $body,
        ]);

        $this->handle(
            $comment
        );
    }
}
