<?php

declare(strict_types=1);

namespace CodelyTv\Analytics\DomainEvents\Domain;

interface DomainEventsRepositoryInterface
{
	public function save(AnalyticsDomainEvent $analyticsDomainEvent): void;
}
