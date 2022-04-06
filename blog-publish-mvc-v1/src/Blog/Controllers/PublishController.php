<?php
namespace App\Blog\Controllers;

use App\Blog\Models\PostEntity;
use App\Blog\Models\Repositories\UserRepository;
use App\Blog\Models\Repositories\PostRepository;
use App\Blog\Models\UserEntity;
use App\Blog\Utils\RequestTrait;
use App\Blog\Utils\ViewTrait;
use App\Blog\Utils\Monolog;
use \Exception;

final class PublishController
{
    use RequestTrait;
    use ViewTrait;

    public function publish(): void
    {
        $userId = $this->getRequestSession("userId", 1);
        $postId = $this->getRequestPost("postId", 1);

        try {
            $userRepository = new UserRepository();
            $user = $userRepository->ofIdOrFail($userId);
            $postRepository = new PostRepository();
            $post = $postRepository->ofIdOrFail($postId);

            $post->publish();
            $postRepository->save($post);
            $this->notifyToUser($post, $user);

            $this->set("post", $post);
        }
        catch (Exception $e) {
            $this->set("error", $e->getMessage());
        }
        pr("rendering saved post ...");
        $this->render("post-published");
    }

    private function notifyToUser(PostEntity $post, UserEntity $user): void
    {
        pr("sending email ...");
        mb_send_mail(
            $user->email(),
            "Your post with id {$post->id()} has been published",
            "Congrats! your post has been published"
        );
        pr("monologging ...");
        (new Monolog())->log("Post with title {$post->title()} published by user {$user->email()}");
    }

}