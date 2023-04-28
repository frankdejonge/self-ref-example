<?php
declare(strict_types=1);

namespace App\Example;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

/**
 * @implements AggregateRoot<ExampleAggregateRootId>
 */
class ExampleAggregate implements AggregateRoot
{
    use AggregateRootBehaviour;

    private int $total = 0;

    public function incrementNumber(int $incrementBy): void
    {
        $this->recordThat(new NumberWasIncremented($incrementBy));
    }

    protected function applyNumberWasIncremented(NumberWasIncremented $event): void
    {
        $this->total += $event->incrementBy;
    }

    public function total(): int
    {
        return $this->total;
    }
}