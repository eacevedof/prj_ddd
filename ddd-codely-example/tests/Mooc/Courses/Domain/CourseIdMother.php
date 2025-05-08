<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses\Domain;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Tests\Shared\Domain\UuidMother;

final class CourseIdMother
{
	public static function create(?string $value = null): CourseIdVO
	{
		return new CourseIdVO($value ?? UuidMother::create());
	}
}
