<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Find;

use CodelyTv\Mooc\Videos\Domain\VideoAG;
use CodelyTv\Mooc\Videos\Domain\VideoFinderDomService as DomainVideoFinder;
use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Mooc\Videos\Domain\VideoRepositoryInterface;

final class VideoFinder
{
	private readonly DomainVideoFinder $finder;

	public function __construct(VideoRepositoryInterface $repository)
	{
		$this->finder = new DomainVideoFinder($repository);
	}

	public function __invoke(VideoIdVO $id): VideoAG
	{
		return $this->finder->__invoke($id);
	}
}
