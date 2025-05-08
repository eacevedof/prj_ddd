<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Increment;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterAG;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterId;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;
use CodelyTv\Shared\Domain\UuidGeneratorInterface;

final readonly class CoursesCounterIncrementerService
{
	public function __construct(
		private CoursesCounterRepositoryInterface $coursesCounterRepositoryInterface,
		private UuidGeneratorInterface            $uuidGeneratorInterface,
		private EventBusInterface                 $eventBusInterface
	) {}

	public function __invoke(CourseIdVO $courseIdVO): void
	{
		$counter = $this->coursesCounterRepositoryInterface->search() ?: $this->initializeCounter();

		if (!$counter->hasIncremented($courseIdVO)) {
			$counter->increment($courseIdVO);

			$this->coursesCounterRepositoryInterface->save($counter);
			$this->eventBusInterface->publish(...$counter->pullDomainEvents());
		}
	}

	private function initializeCounter(): CoursesCounterAG
	{
		return CoursesCounterAG::initialize(
            new CoursesCounterId($this->uuidGeneratorInterface->generate())
        );
	}
}
