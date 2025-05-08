<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure;

use CodelyTv\Shared\Domain\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGeneratorInterface implements UuidGeneratorInterface
{
	public function generate(): string
	{
		return Uuid::uuid4()->toString();
	}
}
