<?php
namespace App\Blog\Application;

use App\Blog\Domain\PostEntity;
use App\Blog\Infrastructure\Repositories\PostRepository;

final class PostPublishService
{
    private PostRepository $postRepository;
    private NotifyService $notifyService;
    private MonologService $monologService;

    public function __construct(
        PostRepository $postRepository,
        NotifyService $notifyService,
        MonologService $monologService
    )
    {
        $this->postRepository = $postRepository;
        $this->notifyService = $notifyService;
        $this->monologService = $monologService;
    }

    public function execute(int $userId, int $postId): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($postId);
        $post->publish();
        $this->postRepository->save($post);
        $this->notifyService->emailOnPostPublished($userId, $postId);
        $this->monologService->logOnPostPublished($userId, $postId);
        return $post;
    }
}