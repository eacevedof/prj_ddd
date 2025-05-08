<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain\Exercise;

use CodelyTv\Mooc\Steps\Domain\AbstractStepAG;
use CodelyTv\Mooc\Steps\Domain\StepDuration;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepTitle;

final class ExerciseAbstractStepAG extends AbstractStepAG
{
	public function __construct(
		StepId $id,
		StepTitle $title,
		StepDuration $duration,
		private readonly ExerciseStepContent $content
	) {
		parent::__construct($id, $title, $duration);
	}
}
