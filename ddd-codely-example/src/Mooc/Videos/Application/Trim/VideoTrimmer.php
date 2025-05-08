<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Trim;

use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Shared\Domain\SecondsIntervalEntity;

final class VideoTrimmer
{
	public function trim(VideoIdVO $videoIdVO, SecondsIntervalEntity $secondsIntervalVO): void {}
}
