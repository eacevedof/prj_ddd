<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Courses\Domain;

use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Tests\Shared\Domain\IntegerMother;
use CodelyTv\Tests\Shared\Domain\RandomElementPicker;

final class CourseDurationMother
{
	public static function create(?string $value = null): CourseDurationVO
	{
		return new CourseDurationVO($value ?? self::random());
	}

	private static function random(): string
	{
		return sprintf(
			'%s %s',
			IntegerMother::lessThan(100),
			RandomElementPicker::from('months', 'years', 'days', 'hours', 'minutes', 'seconds')
		);
	}
}
