<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Domain\Aggregate;

use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;

abstract class AggregateRoot
{
	private array $domainEvents = [];

	final public function pullDomainEvents(): array
	{
		$domainEvents = $this->domainEvents;
		$this->domainEvents = [];

		return $domainEvents;
	}

	final protected function recordDispatchEvent(AbstractDomainEvent $domainEvent): void
	{
		$this->domainEvents[] = $domainEvent;
	}
}
