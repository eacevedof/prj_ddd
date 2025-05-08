<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Infrastructure\Persistence;

use CodelyTv\Mooc\Courses\Domain\CourseAG;
use CodelyTv\Mooc\Courses\Domain\CourseRepositoryInterface;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;

final class FileCourseRepositoryInterface implements CourseRepositoryInterface
{
	private const FILE_PATH = __DIR__ . '/courses';

	public function save(CourseAG $courseAG): void
	{
		file_put_contents($this->fileName($courseAG->id()->value()), serialize($courseAG));
	}

	public function search(CourseIdVO $courseIdVO): ?CourseAG
	{
		return file_exists($this->fileName($courseIdVO->value()))
			? unserialize(file_get_contents($this->fileName($courseIdVO->value())))
			: null;
	}

	private function fileName(string $id): string
	{
		return sprintf('%s.%s.repo', self::FILE_PATH, $id);
	}
}
