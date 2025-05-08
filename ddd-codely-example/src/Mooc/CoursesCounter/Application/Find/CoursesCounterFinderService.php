<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Application\Find;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterNotExistException;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterRepositoryInterface;

final readonly class CoursesCounterFinderService
{
	public function __construct(
        private CoursesCounterRepositoryInterface $coursesCounterRepositoryInterface
    ) {}

	public function __invoke(): CoursesCounterQueryResponse
	{
		$coursesCounterAG = $this->coursesCounterRepositoryInterface->search();
		if ($coursesCounterAG === null) {
			throw new CoursesCounterNotExistException();
		}

		return new CoursesCounterQueryResponse(
            $coursesCounterAG->total()->value()
        );
	}
}
