<?php
declare(strict_types=1);

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'domain_events'),
    ORM\Index(columns: ['aggregate_root_id', 'version'], name: 'reconstitution')
]
class DummyEntityForEventSauceSchema
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'bigint')]
    private ?int $id;

    #[ORM\Column(type: 'uuid')]
    private UuidInterface $eventId;

    #[ORM\Column(name: 'aggregate_root_id', type: 'uuid')]
    private UuidInterface $aggregateRootId;

    #[ORM\Column(type: 'integer')]
    private int $version;
    #[ORM\Column(type: 'text')]
    private string $payload;
}