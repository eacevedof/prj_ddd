<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Mooc\Courses\Domain\CourseCreatedAbstractDomainEvent;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedAbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class TestAllWorksOnRabbitMqEventsPublished implements DomainEventSubscriberInterface
{
	public static function subscribedTo(): array
	{
		return [CourseCreatedAbstractDomainEvent::class, CoursesCounterIncrementedAbstractDomainEvent::class, ];
	}

	public function __invoke(CourseCreatedAbstractDomainEvent | CoursesCounterIncrementedAbstractDomainEvent $event): void {}
}
