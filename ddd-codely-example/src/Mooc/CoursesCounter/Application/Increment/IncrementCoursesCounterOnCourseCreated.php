<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Increment;

use CodelyTv\Mooc\Courses\Domain\CourseCreatedAbstractDomainEvent;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

use function Lambdish\Phunctional\apply;

final readonly class IncrementCoursesCounterOnCourseCreated implements DomainEventSubscriberInterface
{
	public function __construct(
        private CoursesCounterIncrementerService $coursesCounterIncrementerService
    ) {}

	public static function subscribedTo(): array
	{
		return [CourseCreatedAbstractDomainEvent::class];
	}

	public function __invoke(CourseCreatedAbstractDomainEvent $courseCreatedDomainEvent): void
	{
		$courseIdVO = new CourseIdVO($courseCreatedDomainEvent->aggregateId());

		apply($this->coursesCounterIncrementerService, [$courseIdVO]);
	}
}
