<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\CoursesCounter\Domain;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterAG;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterId;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedAbstractDomainEvent;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterTotalVO;

final class CoursesCounterIncrementedDomainEventMother
{
	public static function create(
		?CoursesCounterId $id = null,
		?CoursesCounterTotalVO $total = null
	): CoursesCounterIncrementedAbstractDomainEvent {
		return new CoursesCounterIncrementedAbstractDomainEvent(
			$id?->value() ?? CoursesCounterIdMother::create()->value(),
			$total?->value() ?? CoursesCounterTotalMother::create()->value()
		);
	}

	public static function fromCounter(CoursesCounterAG $counter): CoursesCounterIncrementedAbstractDomainEvent
	{
		return self::create($counter->id(), $counter->total());
	}
}
