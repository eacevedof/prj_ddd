<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Infrastructure\Persistence\Doctrine;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class CourseIdTypeVO extends UuidType
{
	protected function typeClassName(): string
	{
		return CourseIdVO::class;
	}
}
