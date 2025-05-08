<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Shared\Infrastructure\Bus\Event\MySql;

use CodelyTv\Apps\Mooc\Backend\MoocBackendKernel;
use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use CodelyTv\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use CodelyTv\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBusInterface;
use CodelyTv\Tests\Mooc\Courses\Domain\CourseCreatedDomainEventMother;
use CodelyTv\Tests\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEventMother;
use CodelyTv\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class MySqlDoctrineEventBusTest extends InfrastructureTestCase
{
	private MySqlDoctrineEventBusInterface | null $bus;
	private MySqlDoctrineDomainEventsConsumer | null $consumer;

	protected function setUp(): void
	{
		parent::setUp();

		$this->bus = new MySqlDoctrineEventBusInterface($this->service(EntityManager::class));
		$this->consumer = new MySqlDoctrineDomainEventsConsumer(
			$this->service(EntityManager::class),
			$this->service(DomainEventMapping::class)
		);
	}

	/** @test */
	public function it_should_publish_and_consume_domain_events_from_msql(): void
	{
		$domainEvent = CourseCreatedDomainEventMother::create();
		$anotherDomainEvent = CoursesCounterIncrementedDomainEventMother::create();

		$this->bus->publish($domainEvent, $anotherDomainEvent);

		$this->consumer->consume(
			subscribers: fn (AbstractDomainEvent ...$expectedEvents) => $this->assertContainsEquals($domainEvent, $expectedEvents),
			eventsToConsume: 2
		);
	}

	protected function kernelClass(): string
	{
		return MoocBackendKernel::class;
	}
}
