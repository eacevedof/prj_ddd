<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\CoursesCounter\Application\Find;

use CodelyTv\Mooc\CoursesCounter\Application\Find\CoursesCounterQueryResponse;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterTotalVO;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterTotalMother;

final class CoursesCounterResponseMother
{
	public static function create(?CoursesCounterTotalVO $total = null): CoursesCounterQueryResponse
	{
		return new CoursesCounterQueryResponse($total?->value() ?? CoursesCounterTotalMother::create()->value());
	}
}
