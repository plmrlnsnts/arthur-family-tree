<?php

namespace App;

class Character
{
    public function __construct(
        public string $name,
        public string $gender
    ) {}

    public function isMale()
    {
        return $this->gender === 'Male';
    }

    public function isFemale()
    {
        return $this->gender === 'Female';
    }

    public function getMarriageRole(): string
    {
        return $this->isMale() ? 'husband' : 'wife';
    }

    public function getParentRole(): string
    {
        return $this->isMale() ? 'father' : 'mother';
    }
}
