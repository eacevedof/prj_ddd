<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Application\Create;

use CodelyTv\Mooc\Steps\Domain\StepRepositoryInterface;

final readonly class VideoStepCreator
{
	public function __construct(private StepRepositoryInterface $repository) {}

	public function __invoke(): void {}
}
