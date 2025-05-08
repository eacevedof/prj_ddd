<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use AMQPException;
use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;
use CodelyTv\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use CodelyTv\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBusInterface;

use function Lambdish\Phunctional\each;

final readonly class RabbitMqEventBusInterface implements EventBusInterface
{
	public function __construct(
		private RabbitMqConnection             $connection,
		private string                         $exchangeName,
		private MySqlDoctrineEventBusInterface $failoverPublisher
	) {}

	public function publish(AbstractDomainEvent ...$events): void
	{
		each($this->publisher(), $events);
	}

	private function publisher(): callable
	{
		return function (AbstractDomainEvent $event): void {
			try {
				$this->publishEvent($event);
			} catch (AMQPException) {
				$this->failoverPublisher->publish($event);
			}
		};
	}

	private function publishEvent(AbstractDomainEvent $event): void
	{
		$body = DomainEventJsonSerializer::serialize($event);
		$routingKey = $event::eventName();
		$messageId = $event->eventId();

		$this->connection->exchange($this->exchangeName)->publish(
			$body,
			$routingKey,
			AMQP_NOPARAM,
			[
				'message_id' => $messageId,
				'content_type' => 'application/json',
				'content_encoding' => 'utf-8',
			]
		);
	}
}
