<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Application\Update;

use CodelyTv\Mooc\Courses\Application\Find\CourseFinderService;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;

final readonly class CourseRenamerService
{
	private CourseFinderService $courseFinder;

	public function __construct(
        private CourseRepositoryInterface $courseRepositoryInterface,
        private EventBusInterface         $eventBusInterface
    )
	{
		$this->courseFinder = new CourseFinderService($courseRepositoryInterface);
	}

	public function __invoke(
        CourseIdVO $courseIdVO,
        CourseNameVO $courseNameVO): void
	{
		$courseAG = $this->courseFinder->__invoke($courseIdVO);
		$courseAG->rename($courseNameVO);

		$this->courseRepositoryInterface->save($courseAG);

		$this->eventBusInterface->publish(...$courseAG->pullDomainEvents());
	}
}
