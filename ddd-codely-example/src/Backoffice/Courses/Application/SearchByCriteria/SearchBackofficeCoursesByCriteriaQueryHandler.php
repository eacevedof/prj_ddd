<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\SearchByCriteria;

use CodelyTv\Backoffice\Courses\Application\BackofficeCoursesQResponse;
use CodelyTv\Shared\Domain\Bus\Query\QueryHandler;
use CodelyTv\Shared\Domain\Criteria\Filters;
use CodelyTv\Shared\Domain\Criteria\Order;

final readonly class SearchBackofficeCoursesByCriteriaQueryHandler implements QueryHandler
{
	public function __construct(private BackofficeCoursesByCriteriaSearcherService $searcher) {}

	public function __invoke(SearchBackofficeCoursesByCriteriaQuery $query): BackofficeCoursesQResponse
	{
		$filters = Filters::fromValues($query->filters());
		$order = Order::fromValues($query->orderBy(), $query->order());

		return $this->searcher->search($filters, $order, $query->limit(), $query->offset());
	}
}
