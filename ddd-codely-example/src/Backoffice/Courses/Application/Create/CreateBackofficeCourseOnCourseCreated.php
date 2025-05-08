<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Domain\CourseCreatedAbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final readonly class CreateBackofficeCourseOnCourseCreated implements DomainEventSubscriberInterface
{
	public function __construct(
        private BackofficeCourseCreatorService $backofficeCourseCreatorService
    ) {}

	public static function subscribedTo(): array
	{
		return [CourseCreatedAbstractDomainEvent::class];
	}

	public function __invoke(CourseCreatedAbstractDomainEvent $event): void
	{
		$this->backofficeCourseCreatorService->create(
            $event->aggregateId(),
            $event->name(),
            $event->duration()
        );
	}
}
