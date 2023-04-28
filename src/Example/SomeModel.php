<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SomeModelRepository::class), ORM\Table(name: 'some_models')]
class SomeModel
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id;


}