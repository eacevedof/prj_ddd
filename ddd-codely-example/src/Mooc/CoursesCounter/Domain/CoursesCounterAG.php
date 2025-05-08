<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Domain;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

use function Lambdish\Phunctional\search;

final class CoursesCounterAG extends AggregateRoot
{
	private array $existingCourses;

	public function __construct(
        private readonly CoursesCounterId $id,
        private CoursesCounterTotalVO     $total,
        CourseIdVO ...$existingCourses
	) {
		$this->existingCourses = $existingCourses;
	}

	public static function initialize(CoursesCounterId $id): self
	{
		return new self($id, CoursesCounterTotalVO::initialize());
	}

	public function id(): CoursesCounterId
	{
		return $this->id;
	}

	public function total(): CoursesCounterTotalVO
	{
		return $this->total;
	}

	public function existingCourses(): array
	{
		return $this->existingCourses;
	}

	public function increment(CourseIdVO $courseId): void
	{
		$this->total = $this->total->increment();
		$this->existingCourses[] = $courseId;

		$this->recordDispatchEvent(new CoursesCounterIncrementedAbstractDomainEvent($this->id()->value(), $this->total()->value()));
	}

	public function hasIncremented(CourseIdVO $courseId): bool
	{
		$existingCourse = search($this->courseIdComparator($courseId), $this->existingCourses());

		return $existingCourse !== null;
	}

	private function courseIdComparator(CourseIdVO $courseId): callable
	{
		return static fn (CourseIdVO $other): bool => $courseId->equals($other);
	}
}
