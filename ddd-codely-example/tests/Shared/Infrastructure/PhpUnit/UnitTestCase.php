<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Shared\Infrastructure\PhpUnit;

use CodelyTv\Shared\Domain\Bus\Command\Command;
use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;
use CodelyTv\Shared\Domain\Bus\Query\Query;
use CodelyTv\Shared\Domain\Bus\Query\Response;
use CodelyTv\Shared\Domain\UuidGeneratorInterface;
use CodelyTv\Tests\Shared\Domain\TestUtils;
use CodelyTv\Tests\Shared\Infrastructure\Mockery\CodelyTvMatcherIsSimilar;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Throwable;

abstract class UnitTestCase extends MockeryTestCase
{
	private EventBusInterface | MockInterface | null $eventBus = null;
	private MockInterface | UuidGeneratorInterface | null $uuidGenerator = null;

	protected function mock(string $className): MockInterface
	{
		return Mockery::mock($className);
	}

	protected function shouldPublishDomainEvent(AbstractDomainEvent $domainEvent): void
	{
		$this->eventBus()
			->shouldReceive('publish')
			->with($this->similarTo($domainEvent))
			->andReturnNull();
	}

	protected function shouldNotPublishDomainEvent(): void
	{
		$this->eventBus()
			->shouldReceive('publish')
			->withNoArgs()
			->andReturnNull();
	}

	protected function eventBus(): EventBusInterface | MockInterface
	{
		return $this->eventBus ??= $this->mock(EventBusInterface::class);
	}

	protected function shouldGenerateUuid(string $uuid): void
	{
		$this->uuidGenerator()
			->shouldReceive('generate')
			->once()
			->withNoArgs()
			->andReturn($uuid);
	}

	protected function uuidGenerator(): MockInterface | UuidGeneratorInterface
	{
		return $this->uuidGenerator ??= $this->mock(UuidGeneratorInterface::class);
	}

	protected function notify(AbstractDomainEvent $event, callable $subscriber): void
	{
		$subscriber($event);
	}

	protected function dispatch(Command $command, callable $commandHandler): void
	{
		$commandHandler($command);
	}

	protected function assertAskResponse(Response $expected, Query $query, callable $queryHandler): void
	{
		$actual = $queryHandler($query);

		$this->assertEquals($expected, $actual);
	}

	/** @param class-string<Throwable> $expectedErrorClass */
	protected function assertAskThrowsException(string $expectedErrorClass, Query $query, callable $queryHandler): void
	{
		$this->expectException($expectedErrorClass);

		$queryHandler($query);
	}

	protected function isSimilar(mixed $expected, mixed $actual): bool
	{
		return TestUtils::isSimilar($expected, $actual);
	}

	protected function assertSimilar(mixed $expected, mixed $actual): void
	{
		TestUtils::assertSimilar($expected, $actual);
	}

	protected function similarTo(mixed $value, float $delta = 0.0): CodelyTvMatcherIsSimilar
	{
		return TestUtils::similarTo($value, $delta);
	}
}
