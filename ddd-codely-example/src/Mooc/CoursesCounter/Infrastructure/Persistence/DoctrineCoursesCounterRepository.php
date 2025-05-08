<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Infrastructure\Persistence;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterAG;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepositoryInterface;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCoursesCounterRepository extends DoctrineRepository implements CoursesCounterRepositoryInterface
{
	public function save(CoursesCounterAG $coursesCounterAG): void
	{
		$this->persist($coursesCounterAG);
	}

	public function search(): ?CoursesCounterAG
	{
		return $this->repository(CoursesCounterAG::class)->findOneBy([]);
	}
}
