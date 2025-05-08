<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

final readonly class VideoFinderDomService
{
	public function __construct(
        private VideoRepositoryInterface $videoRepositoryInterface
    ) {}

	public function __invoke(VideoIdVO $videoIdVO): VideoAG
	{
		$videoAG = $this->videoRepositoryInterface->search($videoIdVO);
		if ($videoAG === null) {
			throw new VideoNotFoundError($videoIdVO);
		}
		return $videoAG;
	}
}
