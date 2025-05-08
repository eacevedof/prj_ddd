<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Update;

use CodelyTv\Mooc\Videos\Domain\VideoFinderDomService;
use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Mooc\Videos\Domain\VideoRepositoryInterface;
use CodelyTv\Mooc\Videos\Domain\VideoTitleVO;

final readonly class VideoTitleUpdater
{
	private VideoFinderDomService $finder;

	public function __construct(private VideoRepositoryInterface $repository)
	{
		$this->finder = new VideoFinderDomService($repository);
	}

	public function __invoke(VideoIdVO $id, VideoTitleVO $newTitle): void
	{
		$video = $this->finder->__invoke($id);

		$video->updateTitle($newTitle);

		$this->repository->save($video);
	}
}
