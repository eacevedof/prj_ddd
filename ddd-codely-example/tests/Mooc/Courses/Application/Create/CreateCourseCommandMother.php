<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Application\Create\CreateCourseCommand;
use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseDurationMother;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseIdMother;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseNameMother;

final class CreateCourseCommandMother
{
	public static function create(
		?CourseIdVO     $id = null,
		?CourseNameVO   $name = null,
		?CourseDurationVO $duration = null
	): CreateCourseCommand {
		return new CreateCourseCommand(
			$id?->value() ?? CourseIdMother::create()->value(),
			$name?->value() ?? CourseNameMother::create()->value(),
			$duration?->value() ?? CourseDurationMother::create()->value()
		);
	}
}
