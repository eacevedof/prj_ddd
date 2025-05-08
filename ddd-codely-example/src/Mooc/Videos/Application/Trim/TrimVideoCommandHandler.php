<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Trim;

use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Shared\Domain\SecondsIntervalEntity;

final readonly class TrimVideoCommandHandler
{
	public function __construct(private VideoTrimmer $trimmer) {}

	public function __invoke(TrimVideoCommand $trimVideoCommand): void
	{
		$videoIdVO = new VideoIdVO($trimVideoCommand->videoId());
		$interval = SecondsIntervalEntity::fromValues($trimVideoCommand->keepFromSecond(), $trimVideoCommand->keepToSecond());

		$this->trimmer->trim($videoIdVO, $interval);
	}
}
