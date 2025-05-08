<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class CoursesModuleUnitTestCase extends UnitTestCase
{
	private CourseRepositoryInterface | MockInterface | null $repository = null;

	protected function shouldSave(CourseAG $course): void
	{
		$this->repository()
			->shouldReceive('save')
			->with($this->similarTo($course))
			->once()
			->andReturnNull();
	}

	protected function shouldSearch(CourseIdVO $id, ?CourseAG $course): void
	{
		$this->repository()
			->shouldReceive('search')
			->with($this->similarTo($id))
			->once()
			->andReturn($course);
	}

	protected function repository(): CourseRepositoryInterface | MockInterface
	{
		return $this->repository ??= $this->mock(CourseRepositoryInterface::class);
	}
}
