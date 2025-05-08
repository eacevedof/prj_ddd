<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\SearchByCriteria;

use CodelyTv\Backoffice\Courses\Application\BackofficeCourseResponse;
use CodelyTv\Backoffice\Courses\Application\BackofficeCoursesQResponse;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseAG;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepositoryInterface;
use CodelyTv\Shared\Domain\Criteria\Criteria;
use CodelyTv\Shared\Domain\Criteria\Filters;
use CodelyTv\Shared\Domain\Criteria\Order;

use function Lambdish\Phunctional\map;

final readonly class BackofficeCoursesByCriteriaSearcherService
{
	public function __construct(
        private BackofficeCourseRepositoryInterface $backofficeCourseRepositoryInterface
    ) {}

	public function search(Filters $filters, Order $order, ?int $limit, ?int $offset): BackofficeCoursesQResponse
	{
		$criteria = new Criteria($filters, $order, $offset, $limit);

		return new BackofficeCoursesQResponse(
            ...map(
                $this->toResponse(),
                $this->backofficeCourseRepositoryInterface->matching($criteria)
            )
        );
	}

	private function toResponse(): callable
	{
		return static fn (BackofficeCourseAG $course): BackofficeCourseResponse => new BackofficeCourseResponse(
			$course->id(),
			$course->name(),
			$course->duration()
		);
	}
}
