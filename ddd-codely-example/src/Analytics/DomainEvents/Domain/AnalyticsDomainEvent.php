<?php

declare(strict_types=1);

namespace CodelyTv\Analytics\DomainEvents\Domain;

final readonly class AnalyticsDomainEvent
{
	public function __construct(
		private AnalyticsDomainEventIdVO          $analyticsDomainEventIdVO,
		private AnalyticsDomainEventAggregateIdVO $analyticsDomainEventAggregateIdVO,
		private AnalyticsDomainEventNameVO        $analyticsDomainEventNameVO,
		private AnalyticsDomainEventBodyVO        $analyticsDomainEventBodyVO
	) {}
}
