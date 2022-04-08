<?php
namespace App\Blog\Application;

use App\Blog\Application\Events\PostPublishedEvent;
use App\Blog\Infrastructure\EventSourcing\IDomainEvent;
use App\Blog\Infrastructure\EventSourcing\IDomainEventSubscriber;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Infrastructure\Repositories\UserRepository;

final class NotifyService implements IDomainEventSubscriber
{
    private UserRepository $userRepository;
    private PostRepository $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    private function emailOnPostPublished(int $authorId, int $postId): void
    {
        $emailTo = $this->userRepository->ofIdOrFail($authorId)->email();
        pr("sending email ...");
        mb_send_mail(
            $emailTo,
            "Your post with id {$postId} has been published",
            "Congrats!"
        );
    }

    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent)!==PostPublishedEvent::class) return $this;
        $this->emailOnPostPublished(
            $domainEvent->authorId(),
            $domainEvent->postId()
        );
        return $this;
    }
}