<?php

namespace App\Actions;

class GetRelationshipAction extends MeetTheFamilyAction
{
    public static function signature(): string
    {
        return 'GET_RELATIONSHIP';
    }

    public function run(): string
    {
        if (count($this->properties) !== 2) {
            return 'GET_RELATIONSHIP_FAILED';
        }

        if (! $this->familyTree->characterExists($this->getCharacter())) {
            return 'PERSON_NOT_FOUND';
        }

        if (! $this->isRelationshipSupported()) {
            return 'UNSUPPORTED_RELATIONSHIP';
        }

        $relatives = $this->getRelatives();

        if (count($relatives) === 0) {
            return 'NONE';
        }

        return implode(' ', $relatives);
    }

    protected function getCharacter(): string
    {
        return $this->properties[0];
    }

    protected function getRelationship(): string
    {
        return $this->properties[1];
    }

    protected function supportedRelationships(): array
    {
        return [
            'Paternal-Uncle' => 'getPaternalUncles',
            'Maternal-Uncle' => 'getMaternalUncles',
            'Paternal-Aunt' => 'getPaternalAunts',
            'Maternal-Aunt' => 'getMaternalAunts',
            'Sister-In-Law' => 'getSisterInLaws',
            'Brother-In-Law' => 'getBrotherInLaws',
            'Son' => 'getSons',
            'Daughter' => 'getDaughters',
            'Siblings' => 'getSiblings',
        ];
    }

    protected function isRelationshipSupported(): bool
    {
        return in_array(
            $this->getRelationship(),
            array_keys($this->supportedRelationships())
        );
    }

    protected function getRelatives(): array
    {
        $method = $this->supportedRelationships()[$this->getRelationship()];

        return $this->familyTree->{$method}($this->getCharacter());
    }
}
