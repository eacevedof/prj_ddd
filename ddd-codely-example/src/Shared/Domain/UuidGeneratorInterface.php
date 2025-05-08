<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Domain;

interface UuidGeneratorInterface
{
	public function generate(): string;
}
