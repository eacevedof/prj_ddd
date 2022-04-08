<?php
namespace App\Blog\Application;

use App\Blog\Domain\PostEntity;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Application\Commands\PublishCommand;

final class PostPublishingCommandHandler implements ICommandHandler
{
    private IPostRepository $postRepository;
    private NotifyService $notifyService;
    private MonologService $monologService;

    public function __construct(
        IPostRepository $postRepository,
        NotifyService $notifyService,
        MonologService $monologService
    )
    {
        $this->postRepository = $postRepository;
        $this->notifyService = $notifyService;
        $this->monologService = $monologService;
    }

    public function execute(PublishCommand $command): PostEntity
    {
        $post = $this->postRepository->ofIdOrFail($postId = $command->postId());
        $post->publish();
        $this->postRepository->save($post);
        $this->notifyService->emailOnPostPublished($userId = $command->authorId(), $postId);
        $this->monologService->logOnPostPublished($userId, $postId);
        return $post;
    }
}