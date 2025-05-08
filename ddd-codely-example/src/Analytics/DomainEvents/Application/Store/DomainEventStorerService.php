<?php

declare(strict_types=1);

namespace CodelyTv\Analytics\DomainEvents\Application\Store;

use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEvent;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventAggregateIdVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventBodyVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventIdVO;
use CodelyTv\Analytics\DomainEvents\Domain\AnalyticsDomainEventNameVO;
use CodelyTv\Analytics\DomainEvents\Domain\DomainEventsRepositoryInterface;

final readonly class DomainEventStorerService
{
	public function __construct(
        private DomainEventsRepositoryInterface $repository
    ) {}

	public function store(
        AnalyticsDomainEventIdVO          $id,
        AnalyticsDomainEventAggregateIdVO $aggregateId,
        AnalyticsDomainEventNameVO        $name,
        AnalyticsDomainEventBodyVO $body
	): void {
		$domainEvent = new AnalyticsDomainEvent($id, $aggregateId, $name, $body);

		$this->repository->save($domainEvent);
	}
}
