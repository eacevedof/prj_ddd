<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Infrastructure\Cdc;

use CodelyTv\Mooc\Courses\Domain\CourseCreatedAbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Utils;
use CodelyTv\Shared\Infrastructure\Cdc\DatabaseMutationAction;
use CodelyTv\Shared\Infrastructure\Cdc\DatabaseMutationToDomainEventInterface;

final class DatabaseMutationToCourseCreatedDomainEvent implements DatabaseMutationToDomainEventInterface
{
	/** @return AbstractDomainEvent[] */
	public function transform(array $data): array
	{
		$mutation = Utils::jsonDecode($data['new_value']);

		return [
			new CourseCreatedAbstractDomainEvent(
				$mutation['id'],
				$mutation['name'],
				$mutation['duration'],
				null,
				$data['mutation_timestamp'],
			),
		];
	}

	public function tableName(): string
	{
		return 'courses';
	}

	public function mutationAction(): DatabaseMutationAction
	{
		return DatabaseMutationAction::INSERT;
	}
}
