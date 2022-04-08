<?php
namespace App\Blog\Application\Events;

use App\Blog\Infrastructure\EventSourcing\IDomainEvent;

final class PostPublishedEvent implements IDomainEvent
{
    private int $authorId;
    private int $postId;
    private int $occurredOn;

    public function __construct(int $authorId, int $postId)
    {
        $this->authorId = $authorId;
        $this->postId = $postId;
        $this->occurredOn = (new \DateTimeImmutable())->getTimestamp();
    }

    public function authorId():int
    {
        return $this->authorId;
    }

    public function postId():int
    {
        return $this->postId;
    }

    public function occurredOn():int
    {
        return $this->occurredOn;
    }
}