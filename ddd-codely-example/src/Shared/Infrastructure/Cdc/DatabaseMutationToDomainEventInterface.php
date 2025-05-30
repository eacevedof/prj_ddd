<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Cdc;

use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;

interface DatabaseMutationToDomainEventInterface
{
	/** @return AbstractDomainEvent[] */
	public function transform(array $data): array;

	public function tableName(): string;

	public function mutationAction(): DatabaseMutationAction;
}
