<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

use CodelyTv\Shared\Domain\Collection;

final class VideosCollection extends Collection
{
	protected function type(): string
	{
		return VideoAG::class;
	}
}
