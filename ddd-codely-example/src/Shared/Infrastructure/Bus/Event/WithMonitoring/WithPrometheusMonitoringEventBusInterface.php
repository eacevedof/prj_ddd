<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\WithMonitoring;

use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;
use CodelyTv\Shared\Infrastructure\Monitoring\PrometheusMonitor;

use function Lambdish\Phunctional\each;

final readonly class WithPrometheusMonitoringEventBusInterface implements EventBusInterface
{
	public function __construct(
		private PrometheusMonitor $monitor,
		private string            $appName,
		private EventBusInterface $bus
	) {}

	public function publish(AbstractDomainEvent ...$events): void
	{
		$counter = $this->monitor->registry()->getOrRegisterCounter(
			$this->appName,
			'domain_event',
			'Domain Events',
			['name']
		);

		each(fn (AbstractDomainEvent $event) => $counter->inc(['name' => $event::eventName()]), $events);

		$this->bus->publish(...$events);
	}
}
