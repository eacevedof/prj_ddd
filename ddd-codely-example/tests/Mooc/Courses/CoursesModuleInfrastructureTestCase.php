<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses;

use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Tests\Mooc\Shared\Infrastructure\PhpUnit\MoocContextInfrastructureTestCase;

abstract class CoursesModuleInfrastructureTestCase extends MoocContextInfrastructureTestCase
{
	protected function repository(): CourseRepositoryInterface
	{
		return $this->service(CourseRepositoryInterface::class);
	}
}
