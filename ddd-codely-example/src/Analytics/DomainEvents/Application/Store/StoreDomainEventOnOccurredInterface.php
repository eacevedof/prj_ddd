<?php

declare(strict_types=1);

namespace CodelyTv\Analytics\DomainEvents\Application\Store;

use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventAggregateIdVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventBodyVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventIdVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventNameVO;
use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final readonly class StoreDomainEventOnOccurred implements DomainEventSubscriberInterface
{
	public function __construct(
        private DomainEventStorerService $domainEventStorerService
    ) {}

	public static function subscribedTo(): array
	{
		return [AbstractDomainEvent::class];
	}

	public function __invoke(AbstractDomainEvent $event): void
	{
		$id = new AnalyticsDomainEventIdVO($event->eventId());
		$aggregateId = new AnalyticsDomainEventAggregateIdVO($event->aggregateId());
		$name = new AnalyticsDomainEventNameVO($event::eventName());
		$body = new AnalyticsDomainEventBodyVO($event->toPrimitives());

		$this->domainEventStorerService->store($id, $aggregateId, $name, $body);
	}
}
