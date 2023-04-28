<?php
declare(strict_types=1);

namespace App\Entity;

class DummyService
{
    public function __construct(private SomeModelRepository $repository)
    {
    }
}