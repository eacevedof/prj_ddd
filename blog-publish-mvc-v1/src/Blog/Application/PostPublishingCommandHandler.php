<?php
namespace App\Blog\Application;

use App\Blog\Domain\PostEntity;
use App\Blog\Domain\Ports\IPostRepository;
use App\Blog\Application\Commands\PublishCommand;
use App\Blog\Application\Events\PostPublishedEvent;
use App\Blog\Infrastructure\EventSourcing\DomainEventPublisher;

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
        DomainEventPublisher::instance()->subscribe($this->notifyService);
        DomainEventPublisher::instance()->subscribe($this->monologService);

        $post = $this->postRepository->ofIdOrFail($command->postId());
        $post->publish();
        $this->postRepository->save($post);
        DomainEventPublisher::instance()->publish(new PostPublishedEvent(
            $command->authorId(),
            $command->postId()
        ));
        return $post;
    }
}