<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\CoursesCounter;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterAG;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepositoryInterface;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class CoursesCounterModuleUnitTestCase extends UnitTestCase
{
	private CoursesCounterRepositoryInterface | MockInterface | null $repository = null;

	protected function shouldSave(CoursesCounterAG $course): void
	{
		$this->repository()
			->shouldReceive('save')
			->once()
			->with($this->similarTo($course))
			->andReturnNull();
	}

	protected function shouldSearch(?CoursesCounterAG $counter): void
	{
		$this->repository()
			->shouldReceive('search')
			->once()
			->andReturn($counter);
	}

	protected function repository(): CoursesCounterRepositoryInterface | MockInterface
	{
		return $this->repository ??= $this->mock(CoursesCounterRepositoryInterface::class);
	}
}
