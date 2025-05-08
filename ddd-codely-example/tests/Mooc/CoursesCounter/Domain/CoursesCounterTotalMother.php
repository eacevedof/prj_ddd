<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\CoursesCounter\Domain;

use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterTotalVO;
use CodelyTv\Tests\Shared\Domain\IntegerMother;

final class CoursesCounterTotalMother
{
	public static function create(?int $value = null): CoursesCounterTotalVO
	{
		return new CoursesCounterTotalVO($value ?? IntegerMother::create());
	}

	public static function one(): CoursesCounterTotalVO
	{
		return self::create(1);
	}

	public static function random(): CoursesCounterTotalVO
	{
		return self::create(IntegerMother::create());
	}
}
