<?php
namespace App\Blog\Infrastructure\EventSourcing;

interface IDomainEvent
{
    public function occurredOn(): int;
}