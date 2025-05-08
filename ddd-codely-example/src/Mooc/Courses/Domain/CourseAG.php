<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Domain;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

final class CourseAG extends AggregateRoot
{
	public function __construct(
        private readonly CourseIdVO       $courseIdVO,
        private CourseNameVO              $courseNameVO,
        private readonly CourseDurationVO $courseDurationVO
    ) {}

	public static function create(
        CourseIdVO       $courseIdVO,
        CourseNameVO     $courseNameVO,
        CourseDurationVO $courseDurationVO
    ): self
	{
		$course = new self($courseIdVO, $courseNameVO, $courseDurationVO);
		$course->recordDispatchEvent(
            new CourseCreatedAbstractDomainEvent(
                $courseIdVO->value(),
                $courseNameVO->value(),
                $courseDurationVO->value()
            )
        );
		return $course;
	}

	public function id(): CourseIdVO
	{
		return $this->courseIdVO;
	}

	public function name(): CourseNameVO
	{
		return $this->courseNameVO;
	}

	public function duration(): CourseDurationVO
	{
		return $this->courseDurationVO;
	}

	public function rename(CourseNameVO $newName): void
	{
		$this->courseNameVO = $newName;
	}
}
