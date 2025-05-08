<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses\Domain;

use CodelyTv\Mooc\Courses\Application\Create\CreateCourseCommand;
use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;

final class CourseMother
{
	public static function create(
		?CourseIdVO     $id = null,
		?CourseNameVO   $name = null,
		?CourseDurationVO $duration = null
	): CourseAG {
		return new CourseAG(
			$id ?? CourseIdMother::create(),
			$name ?? CourseNameMother::create(),
			$duration ?? CourseDurationMother::create()
		);
	}

	public static function fromRequest(CreateCourseCommand $request): CourseAG
	{
		return self::create(
			CourseIdMother::create($request->id()),
			CourseNameMother::create($request->name()),
			CourseDurationMother::create($request->duration())
		);
	}
}
