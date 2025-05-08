<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Infrastructure\Persistence;

use CodelyTv\Mooc\Steps\Domain\AbstractStepAG;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepRepositoryInterface;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlStepRepositoryInterface extends DoctrineRepository implements StepRepositoryInterface
{
	public function save(AbstractStepAG $step): void
	{
		$this->persist($step);
	}

	public function search(StepId $id): ?AbstractStepAG
	{
		return $this->repository(AbstractStepAG::class)->find($id);
	}

	public function delete(AbstractStepAG $step): void
	{
		$this->remove($step);
	}
}
