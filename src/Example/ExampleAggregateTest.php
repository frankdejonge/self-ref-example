<?php
declare(strict_types=1);

namespace App\Example;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;

class ExampleAggregateTest extends AggregateRootTestCase
{
    public function handle(AggregateRootId $id, string $method, ...$arguments)
    {
        $aggregate = $this->repository->retrieve($id);

        try {
            $aggregate->{$method}(...$arguments);
        } finally {
            $this->repository->persist($aggregate);
        }
    }

    protected function newAggregateRootId(): AggregateRootId
    {
        return ExampleAggregateRootId::generate();
    }

    protected function aggregateRootClassName(): string
    {
        return ExampleAggregate::class;
    }

    protected function messageDispatcher(): MessageDispatcher
    {
        return new SynchronousMessageDispatcher();
    }

    /**
     * @test
     */
    public function incrementing_a_number(): void
    {
        $this->when($this->aggregateRootId, 'incrementNumber', 10)
            ->then(
                new NumberWasIncremented(10),
            );
    }
}