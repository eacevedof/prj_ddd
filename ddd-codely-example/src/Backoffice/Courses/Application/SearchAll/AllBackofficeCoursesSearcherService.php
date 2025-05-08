<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\SearchAll;

use CodelyTv\Backoffice\Courses\Application\BackofficeCourseResponse;
use CodelyTv\Backoffice\Courses\Application\BackofficeCoursesQResponse;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseAG;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepositoryInterface;

use function Lambdish\Phunctional\map;

final readonly class AllBackofficeCoursesSearcherService
{
	public function __construct(
        private BackofficeCourseRepositoryInterface $backofficeCourseRepositoryInterface
    ) {}

	public function searchAll(): BackofficeCoursesQResponse
	{
		return new BackofficeCoursesQResponse(
            ...map($this->toResponse(), $this->backofficeCourseRepositoryInterface->searchAll())
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
