<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Domain\Bus\Event;

interface EventBusInterface
{
	public function publish(AbstractDomainEvent ...$events): void;
}
