<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Infrastructure\Persistence;

use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseAG;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepositoryInterface;
use CodelyTv\Shared\Domain\Criteria\Criteria;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlBackofficeCourseRepositoryInterface extends DoctrineRepository implements BackofficeCourseRepositoryInterface
{
	public function save(BackofficeCourseAG $course): void
	{
		$this->persist($course);
	}

	public function searchAll(): array
	{
		return $this->repository(BackofficeCourseAG::class)->findAll();
	}

	public function matching(Criteria $criteria): array
	{
		$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

		return $this->repository(BackofficeCourseAG::class)->matching($doctrineCriteria)->toArray();
	}
}
