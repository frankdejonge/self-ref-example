<?php
declare(strict_types=1);

namespace App\Example;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Ramsey\Uuid\UuidInterface;
use function dump;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\Table(name: 'person' )]
class Person implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * @var Collection<Person>
     */
    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'friends')]
    private Collection $friends;

    public function __construct(UuidInterface $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->friends = new ArrayCollection();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addFriend(Person $person): void
    {
        $this->friends->add($person);
    }

    /**
     * @return array
     */
    public function idsOfAllMyFriends(): array
    {
        dump($this->friends->toArray());
        return $this->friends->map(fn($p) => $p->id())->toArray();
    }

    public function jsonSerialize(): mixed
    {
        return ['id' => $this->id->toString(), 'name' => $this->name];
    }
}