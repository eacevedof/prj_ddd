<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\CoursesCounter\Domain;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterAG;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterId;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterTotalVO;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseIdMother;
use CodelyTv\Tests\Shared\Domain\Repeater;

final class CoursesCounterMother
{
	public static function create(
        ?CoursesCounterId      $id = null,
        ?CoursesCounterTotalVO $total = null,
        CourseIdVO ...$existingCourses
	): CoursesCounterAG {
		return new CoursesCounterAG(
			$id ?? CoursesCounterIdMother::create(),
			$total ?? CoursesCounterTotalMother::create(),
			...count($existingCourses) ? $existingCourses : Repeater::random(fn (): CourseIdVO => CourseIdMother::create())
		);
	}

	public static function withOne(CourseIdVO $courseId): CoursesCounterAG
	{
		return self::create(CoursesCounterIdMother::create(), CoursesCounterTotalMother::one(), $courseId);
	}

	public static function incrementing(CoursesCounterAG $existingCounter, CourseIdVO $courseId): CoursesCounterAG
	{
		return self::create(
			$existingCounter->id(),
			CoursesCounterTotalMother::create($existingCounter->total()->value() + 1),
			...array_merge($existingCounter->existingCourses(), [$courseId])
		);
	}
}
