<?php
declare(strict_types=1);

namespace App\Example;

class NumberWasIncremented
{
    public function __construct(public readonly int $incrementBy)
    {
    }
}