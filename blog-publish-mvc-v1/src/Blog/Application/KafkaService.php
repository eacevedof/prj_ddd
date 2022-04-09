<?php
namespace App\Blog\Application;

use App\Blog\Application\Events\PostPublishedEvent;
use App\Blog\Infrastructure\EventSourcing\IDomainEvent;
use App\Blog\Infrastructure\EventSourcing\IDomainEventSubscriber;
use App\Blog\Infrastructure\Kafka;

final class KafkaService implements IDomainEventSubscriber
{
    public function onDomainEvent(IDomainEvent $domainEvent): IDomainEventSubscriber
    {
        if (get_class($domainEvent)!==PostPublishedEvent::class) return $this;

        (new Kafka())->produce(serialize($domainEvent), PostPublishedEvent::class);
        return $this;
    }
}