<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain\Video;

use CodelyTv\Mooc\Steps\Domain\AbstractStepAG;
use CodelyTv\Mooc\Steps\Domain\StepDuration;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepTitle;

final class VideoAbstractStepAG extends AbstractStepAG
{
	public function __construct(
		StepId $id,
		StepTitle $title,
		StepDuration $duration,
		private readonly VideoStepUrl $url
	) {
		parent::__construct($id, $title, $duration);
	}
}
