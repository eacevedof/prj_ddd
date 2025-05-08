<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Infrastructure\Persistence;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCourseRepository extends DoctrineRepository implements CourseRepositoryInterface
{
	public function save(CourseAG $courseAG): void
	{
		$this->persist($courseAG);
	}

	public function search(CourseIdVO $courseIdVO): ?CourseAG
	{
		return $this->repository(CourseAG::class)->find($courseIdVO);
	}
}
