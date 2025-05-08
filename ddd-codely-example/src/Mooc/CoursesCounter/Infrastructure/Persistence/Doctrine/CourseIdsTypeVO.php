<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\CoursesCounter\Infrastructure\Persistence\Doctrine;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

use function Lambdish\Phunctional\map;

final class CourseIdsTypeVO extends JsonType implements DoctrineCustomType
{
	public static function customTypeName(): string
	{
		return 'course_ids';
	}

	public function getName(): string
	{
		return self::customTypeName();
	}

	public function convertToDatabaseValue(
                         $value,
        AbstractPlatform $abstractPlatform): ?string
	{
		return parent::convertToDatabaseValue(
            map(fn (CourseIdVO $courseIdVO): string => $courseIdVO->value(), $value),
            $abstractPlatform
        );
	}

	public function convertToPHPValue(
        $value,
        AbstractPlatform $abstractPlatform
    ): array
	{
		$scalars = parent::convertToPHPValue($value, $abstractPlatform);
		return map(
            fn (string $value): CourseIdVO => new CourseIdVO($value),
            $scalars
        );
	}
}
