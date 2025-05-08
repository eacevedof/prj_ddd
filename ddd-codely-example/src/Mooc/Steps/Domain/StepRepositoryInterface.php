<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain;

interface StepRepositoryInterface
{
	public function save(AbstractStepAG $step): void;

	public function search(StepId $id): ?AbstractStepAG;

	public function delete(AbstractStepAG $step): void;
}
