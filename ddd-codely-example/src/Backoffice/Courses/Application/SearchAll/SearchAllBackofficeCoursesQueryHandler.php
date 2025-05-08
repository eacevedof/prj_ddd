<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\SearchAll;

use CodelyTv\Backoffice\Courses\Application\BackofficeCoursesQResponse;
use CodelyTv\Shared\Domain\Bus\Query\QueryHandler;

final readonly class SearchAllBackofficeCoursesQueryHandler implements QueryHandler
{
	public function __construct(private AllBackofficeCoursesSearcherService $searcher) {}

	public function __invoke(SearchAllBackofficeCoursesQuery $query): BackofficeCoursesQResponse
	{
		return $this->searcher->searchAll();
	}
}
