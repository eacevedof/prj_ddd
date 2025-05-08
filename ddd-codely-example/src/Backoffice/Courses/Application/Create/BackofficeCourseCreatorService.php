<?php

declare(strict_types=1);

namespace CodelyTv\Backoffice\Courses\Application\Create;

use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseAG;
use CodelyTv\Backoffice\Courses\Domain\BackofficeCourseRepositoryInterface;

final readonly class BackofficeCourseCreatorService
{
	public function __construct(
        private BackofficeCourseRepositoryInterface $backofficeCourseRepository
    ) {}

	public function create(string $id, string $name, string $duration): void
	{
		$this->backofficeCourseRepository->save(
            new BackofficeCourseAG($id, $name, $duration)
        );
	}
}
