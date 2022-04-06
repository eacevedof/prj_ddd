<?php
namespace App\Blog\Application;

use App\Blog\Domain\PostEntity;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Domain\UserEntity;
use App\Blog\Infrastructure\Monolog;

final class PostPublishService
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function execute(int $userId, int $postId): PostEntity
    {
        $user = $this->userRepository->ofIdOrFail($userId);
        $post = $this->postRepository->ofIdOrFail($postId);
        $post->publish();
        $this->postRepository->save($post);
        $this->notifyToUser($post, $user);
        return $post;
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