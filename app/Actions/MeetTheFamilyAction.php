<?php

namespace App\Actions;

use App\FamilyTree;

abstract class MeetTheFamilyAction
{
    public function __construct(
        protected FamilyTree $familyTree,
        protected array $properties
    ) {}

    abstract public static function signature(): string;

    abstract public function run(): string;
}
