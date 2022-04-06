<?php
namespace App\Blog\Application;

use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Infrastructure\Monolog;

final class MonologService
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function logOnPostPublished(int $authorId, int $postId): void
    {
        $emailTo = $this->userRepository->ofIdOrFail($authorId)->email();
        $title = $this->postRepository->ofIdOrFail($postId)->title();
        pr("monologging ...");
        (new Monolog())->log("Post with title {$title} published by user {$emailTo}");
    }
}