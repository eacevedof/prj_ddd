<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Domain;

use DomainException;

final readonly class SecondsIntervalEntity
{
	public function __construct(private SecondVO $from, private SecondVO $to)
	{
		$this->ensureIntervalEndsAfterStart($from, $to);
	}

	public static function fromValues(int $from, int $to): self
	{
		return new self(new SecondVO($from), new SecondVO($to));
	}

	private function ensureIntervalEndsAfterStart(SecondVO $fromVO, SecondVO $toVO): void
	{
		if ($fromVO->isBiggerThan($toVO)) {
			throw new DomainException('To is bigger than from');
		}
	}
}
