<?php
declare(strict_types=1);

namespace App\Example;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class ExampleAggregateRootId implements AggregateRootId
{
    public function __construct(private string $aggregateRootId)
    {
    }

    public function toString(): string
    {
        return $this->aggregateRootId;
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }
}