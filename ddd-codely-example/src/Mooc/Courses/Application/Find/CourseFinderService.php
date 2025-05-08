<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Application\Find;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseNotExist;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;

final readonly class CourseFinderService
{
	public function __construct(
        private CourseRepositoryInterface $courseRepositoryInterface
    ) {}

	public function __invoke(
        CourseIdVO $courseIdVO
    ): CourseAG
	{
		$courseAG = $this->courseRepositoryInterface->search($courseIdVO);
		if ($courseAG === null) {
			throw new CourseNotExist($courseIdVO);
		}
		return $courseAG;
	}
}
