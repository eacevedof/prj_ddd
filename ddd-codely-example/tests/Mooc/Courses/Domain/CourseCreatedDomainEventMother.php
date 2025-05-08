<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses\Domain;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseCreatedAbstractDomainEvent;
use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;

final class CourseCreatedDomainEventMother
{
	public static function create(
		?CourseIdVO     $id = null,
		?CourseNameVO   $name = null,
		?CourseDurationVO $duration = null
	): CourseCreatedAbstractDomainEvent {
		return new CourseCreatedAbstractDomainEvent(
			$id?->value() ?? CourseIdMother::create()->value(),
			$name?->value() ?? CourseNameMother::create()->value(),
			$duration?->value() ?? CourseDurationMother::create()->value()
		);
	}

	public static function fromCourse(CourseAG $course): CourseCreatedAbstractDomainEvent
	{
		return self::create($course->id(), $course->name(), $course->duration());
	}
}
