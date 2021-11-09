<?php

namespace App\Actions;

use App\Character;
use App\Filiation;

class AddChildAction extends MeetTheFamilyAction
{
    public static function signature(): string
    {
        return 'ADD_CHILD';
    }

    public function run(): string
    {
        if (count($this->properties) !== 3) {
            return 'CHILD_ADDITION_FAILED';
        }

        if ($this->familyTree->characterExists($this->getChild())) {
            return 'PERSON_ALREADY_EXISTS';
        }

        if (! $this->familyTree->characterExists($this->getMother())) {
            return 'PERSON_NOT_FOUND';
        }

        if (! $this->familyTree->characterExists($this->getFather())) {
            return 'PERSON_NOT_FOUND';
        }

        if ($this->familyTree->findCharacter($this->getMother())->isMale()) {
            return 'CHILD_ADDITION_FAILED';
        }

        $this->familyTree->addCharacter(new Character(
            $this->getChild(),
            $this->getGender()
        ));

        $this->familyTree->addFiliation(new Filiation(
            $this->getFather(),
            $this->getMother(),
            $this->getChild()
        ));

        return 'CHILD_ADDED';
    }

    protected function getMother(): string
    {
        return $this->properties[0];
    }

    protected function getFather(): string
    {
        return $this->familyTree->findSpouse($this->getMother()) ?? '';
    }

    protected function getChild(): string
    {
        return $this->properties[1];
    }

    protected function getGender(): string
    {
        return $this->properties[2];
    }
}
