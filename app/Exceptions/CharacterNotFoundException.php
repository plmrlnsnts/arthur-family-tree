<?php

namespace App\Exceptions;

use Exception;

class CharacterNotFoundException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct("{$name} does not exist in the family tree.");
    }
}
