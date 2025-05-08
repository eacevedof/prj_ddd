<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\InMemory;

use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;
use CodelyTv\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBusInterface implements EventBusInterface
{
	private readonly MessageBus $bus;

	public function __construct(iterable $subscribers)
	{
		$this->bus = new MessageBus(
			[
				new HandleMessageMiddleware(
					new HandlersLocator(CallableFirstParameterExtractor::forPipedCallables($subscribers))
				),
			]
		);
	}

	public function publish(AbstractDomainEvent ...$events): void
	{
		foreach ($events as $event) {
			try {
				$this->bus->dispatch($event);
			} catch (NoHandlerForMessageException) {
			}
		}
	}
}
