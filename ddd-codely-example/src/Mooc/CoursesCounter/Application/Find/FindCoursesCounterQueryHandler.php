<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Find;

use CodelyTv\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindCoursesCounterQueryHandler implements QueryHandler
{
	public function __construct(private CoursesCounterFinderService $finder) {}

	public function __invoke(
        FindCoursesCounterQuery $findCoursesCounterQuery
    ): CoursesCounterQueryResponse
	{
		return $this->finder->__invoke();
	}
}
