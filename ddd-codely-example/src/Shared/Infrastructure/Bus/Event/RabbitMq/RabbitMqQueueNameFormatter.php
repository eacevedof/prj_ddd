<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Bus\Event\RabbitMq;

use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use CodelyTv\Shared\Domain\Utils;

use function Lambdish\Phunctional\last;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
	public static function format(DomainEventSubscriberInterface $subscriber): string
	{
		$subscriberClassPaths = explode('\\', str_replace('CodelyTv', 'codelytv', $subscriber::class));

		$queueNameParts = [
			$subscriberClassPaths[0],
			$subscriberClassPaths[1],
			$subscriberClassPaths[2],
			last($subscriberClassPaths),
		];

		return implode('.', map(self::toSnakeCase(), $queueNameParts));
	}

	public static function formatRetry(DomainEventSubscriberInterface $subscriber): string
	{
		$queueName = self::format($subscriber);

		return "retry.$queueName";
	}

	public static function formatDeadLetter(DomainEventSubscriberInterface $subscriber): string
	{
		$queueName = self::format($subscriber);

		return "dead_letter.$queueName";
	}

	public static function shortFormat(DomainEventSubscriberInterface $subscriber): string
	{
		$subscriberCamelCaseName = (string) last(explode('\\', $subscriber::class));

		return Utils::toSnakeCase($subscriberCamelCaseName);
	}

	private static function toSnakeCase(): callable
	{
		return static fn (string $text): string => Utils::toSnakeCase($text);
	}
}
