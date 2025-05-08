<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Domain;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;

interface CourseRepositoryInterface
{
	public function save(CourseAG $courseAG): void;

	public function search(CourseIdVO $courseIdVO): ?CourseAG;
}
