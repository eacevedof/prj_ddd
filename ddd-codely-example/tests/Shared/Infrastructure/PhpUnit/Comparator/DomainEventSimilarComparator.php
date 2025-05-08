<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Shared\Infrastructure\PhpUnit\Comparator;

use CodelyTv\Shared\Domain\Bus\Event\AbstractDomainEvent;
use CodelyTv\Tests\Shared\Domain\TestUtils;
use ReflectionObject;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

final class DomainEventSimilarComparator extends Comparator
{
	private static array $ignoredAttributes = ['eventId', 'occurredOn'];

	public function accepts($expected, $actual): bool
	{
		$domainEventRootClass = AbstractDomainEvent::class;

		return $expected instanceof $domainEventRootClass && $actual instanceof $domainEventRootClass;
	}

	public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false): void
	{
		if (!$this->areSimilar($expected, $actual)) {
			throw new ComparisonFailure(
				$expected,
				$actual,
				$this->exporter->export($expected),
				$this->exporter->export($actual),
				false,
				'Failed asserting the events are equal.'
			);
		}
	}

	private function areSimilar(AbstractDomainEvent $expected, AbstractDomainEvent $actual): bool
	{
		if (!$this->areTheSameClass($expected, $actual)) {
			return false;
		}

		return $this->propertiesAreSimilar($expected, $actual);
	}

	private function areTheSameClass(AbstractDomainEvent $expected, AbstractDomainEvent $actual): bool
	{
		return $expected::class === $actual::class;
	}

	private function propertiesAreSimilar(AbstractDomainEvent $expected, AbstractDomainEvent $actual): bool
	{
		$expectedReflected = new ReflectionObject($expected);
		$actualReflected = new ReflectionObject($actual);

		foreach ($expectedReflected->getProperties() as $expectedReflectedProperty) {
			if (!in_array($expectedReflectedProperty->getName(), self::$ignoredAttributes, false)) {
				$actualReflectedProperty = $actualReflected->getProperty($expectedReflectedProperty->getName());

				$expectedReflectedProperty->setAccessible(true);
				$actualReflectedProperty->setAccessible(true);

				$expectedProperty = $expectedReflectedProperty->getValue($expected);
				$actualProperty = $actualReflectedProperty->getValue($actual);

				if (!TestUtils::isSimilar($expectedProperty, $actualProperty)) {
					return false;
				}
			}
		}

		return true;
	}
}
