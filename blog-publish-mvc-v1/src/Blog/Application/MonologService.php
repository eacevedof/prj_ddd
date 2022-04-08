<?php
namespace App\Blog\Application;

use App\Blog\Application\Events\PostPublishedEvent;
use App\Blog\Infrastructure\EventSourcing\IDomainEvent;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Infrastructure\Monolog;
use App\Blog\Infrastructure\EventSourcing\IDomainEventSubscriber;

final class MonologService implements IDomainEventSubscriber
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    private function logOnPostPublished(int $authorId, int $postId): void
    {
        $emailTo = $this->userRepository->ofIdOrFail($authorId)->email();
        $title = $this->postRepository->ofIdOrFail($postId)->title();
        pr("monologging ...");
        (new Monolog())->log("Post with title {$title} published by user {$emailTo}");
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent)!==PostPublishedEvent::class) return $this;
        $this->logOnPostPublished(
            $domainEvent->authorId(),
            $domainEvent->postId()
        );
        return $this;
    }
}