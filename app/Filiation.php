<?php

namespace App;

class Filiation
{
    public function __construct(
        public string $father,
        public string $mother,
        public string $child
    ) {}
}
