<?php
namespace App\Blog\Infrastructure\EventSourcing;

interface IDomainEventSubscriber
{
    public function onDomainEvent(IDomainEvent $domainEvent): self;
}