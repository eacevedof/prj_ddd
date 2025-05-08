<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;

final readonly class CourseCreatorService
{
	public function __construct(
        private CourseRepositoryInterface $courseRepository,
        private EventBusInterface         $bus,
        private ValidationService         $validationService,
    ) {}

	public function __invoke(CourseId $id, CourseName $name, CourseDuration $duration): void
	{
		$course = CourseAG::create($id, $name, $duration);

		$this->courseRepository->save($course);
		$this->bus->publish(...$course->pullDomainEvents());
	}
}
