<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Domain;

interface CoursesCounterRepositoryInterface
{
	public function save(CoursesCounterAG $coursesCounterAG): void;

	public function search(): ?CoursesCounterAG;
}
