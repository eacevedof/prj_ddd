<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Infrastructure\Persistence;

use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseAG;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepositoryInterface;
use CodelyTv\Shared\Domain\Criteria\Criteria;
use CodelyTv\Shared\Infrastructure\Persistence\Elasticsearch\ElasticsearchRepository;

use function Lambdish\Phunctional\map;

final class ElasticsearchBackofficeCourseRepositoryInterface extends ElasticsearchRepository implements BackofficeCourseRepositoryInterface
{
	public function save(BackofficeCourseAG $course): void
	{
		$this->persist($course->id(), $course->toPrimitives());
	}

	public function searchAll(): array
	{
		return map($this->toCourse(), $this->searchAllInElastic());
	}

	public function matching(Criteria $criteria): array
	{
		return map($this->toCourse(), $this->searchByCriteria($criteria));
	}

	protected function aggregateName(): string
	{
		return 'courses';
	}

	private function toCourse(): callable
	{
		return static fn (array $primitives): BackofficeCourseAG => BackofficeCourseAG::fromPrimitives($primitives);
	}
}
