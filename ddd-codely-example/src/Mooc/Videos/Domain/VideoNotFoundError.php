<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

use CodelyTv\Shared\Domain\DomainError;

final class VideoNotFoundError extends DomainError
{
	public function __construct(private readonly VideoIdVO $id)
	{
		parent::__construct();
	}

	public function errorCode(): string
	{
		return 'video_not_found';
	}

	protected function errorMessage(): string
	{
		return sprintf('The video <%s> has not been found', $this->id->value());
	}
}
