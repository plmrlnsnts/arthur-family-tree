<?php

namespace App;

use App\Exceptions\CharacterNotFoundException;
use Illuminate\Support\Collection;

class FamilyTree
{
    public Collection $characters;
    public Collection $marriages;
    public Collection $filiations;

    public function __construct()
    {
        $this->characters = new Collection();
        $this->marriages = new Collection();
        $this->filiations = new Collection();
    }

    public static function make(): FamilyTree
    {
        return tap(new static, function ($familyTree) {
            $familyTree->addCharacter(new Character('King Arthur', 'Male'));
            $familyTree->addCharacter(new Character('Queen Margret', 'Female'));
            $familyTree->addCharacter(new Character('Bill', 'Male'));
            $familyTree->addCharacter(new Character('Flora', 'Female'));
            $familyTree->addCharacter(new Character('Victoire', 'Female'));
            $familyTree->addCharacter(new Character('Ted', 'Male'));
            $familyTree->addCharacter(new Character('Remus', 'Male'));
            $familyTree->addCharacter(new Character('Dominique', 'Female'));
            $familyTree->addCharacter(new Character('Louis', 'Male'));
            $familyTree->addCharacter(new Character('Charlie', 'Male'));
            $familyTree->addCharacter(new Character('Percy', 'Male'));
            $familyTree->addCharacter(new Character('Audrey', 'Female'));
            $familyTree->addCharacter(new Character('Molly', 'Female'));
            $familyTree->addCharacter(new Character('Lucy', 'Female'));
            $familyTree->addCharacter(new Character('Ronald', 'Male'));
            $familyTree->addCharacter(new Character('Helen', 'Female'));
            $familyTree->addCharacter(new Character('Malfoy', 'Male'));
            $familyTree->addCharacter(new Character('Rose', 'Female'));
            $familyTree->addCharacter(new Character('Draco', 'Male'));
            $familyTree->addCharacter(new Character('Aster', 'Female'));
            $familyTree->addCharacter(new Character('Hugo', 'Male'));
            $familyTree->addCharacter(new Character('Ginerva', 'Female'));
            $familyTree->addCharacter(new Character('Harry', 'Male'));
            $familyTree->addCharacter(new Character('Darcy', 'Female'));
            $familyTree->addCharacter(new Character('James', 'Male'));
            $familyTree->addCharacter(new Character('William', 'Male'));
            $familyTree->addCharacter(new Character('Alice', 'Female'));
            $familyTree->addCharacter(new Character('Albus', 'Male'));
            $familyTree->addCharacter(new Character('Ron', 'Male'));
            $familyTree->addCharacter(new Character('Ginny', 'Female'));
            $familyTree->addCharacter(new Character('Lily', 'Female'));

            $familyTree->addMarriage(new Marriage('King Arthur', 'Queen Margret'));
            $familyTree->addMarriage(new Marriage('Bill', 'Flora'));
            $familyTree->addMarriage(new Marriage('Ted', 'Victoire'));
            $familyTree->addMarriage(new Marriage('Percy', 'Audrey'));
            $familyTree->addMarriage(new Marriage('Ronald', 'Hellen'));
            $familyTree->addMarriage(new Marriage('Malfoy', 'Rose'));
            $familyTree->addMarriage(new Marriage('Harry', 'Ginerva'));
            $familyTree->addMarriage(new Marriage('James', 'Darcy'));
            $familyTree->addMarriage(new Marriage('Albus', 'Alice'));

            $familyTree->addFiliation(new Filiation('King Arthur', 'Queen Margret', 'Bill'));
            $familyTree->addFiliation(new Filiation('King Arthur', 'Queen Margret', 'Charlie'));
            $familyTree->addFiliation(new Filiation('King Arthur', 'Queen Margret', 'Percy'));
            $familyTree->addFiliation(new Filiation('King Arthur', 'Queen Margret', 'Ronald'));
            $familyTree->addFiliation(new Filiation('King Arthur', 'Queen Margret', 'Ginerva'));
            $familyTree->addFiliation(new Filiation('Bill', 'Flora', 'Victoire'));
            $familyTree->addFiliation(new Filiation('Bill', 'Flora', 'Dominique'));
            $familyTree->addFiliation(new Filiation('Bill', 'Flora', 'Louis'));
            $familyTree->addFiliation(new Filiation('Ted', 'Victoire', 'Remus'));
            $familyTree->addFiliation(new Filiation('Percy', 'Audrey', 'Molly'));
            $familyTree->addFiliation(new Filiation('Percy', 'Audrey', 'Lucy'));
            $familyTree->addFiliation(new Filiation('Ronald', 'Helen', 'Rose'));
            $familyTree->addFiliation(new Filiation('Ronald', 'Helen', 'Hugo'));
            $familyTree->addFiliation(new Filiation('Malfoy', 'Rose', 'Draco'));
            $familyTree->addFiliation(new Filiation('Malfoy', 'Rose', 'Aster'));
            $familyTree->addFiliation(new Filiation('Harry', 'Ginerva', 'James'));
            $familyTree->addFiliation(new Filiation('Harry', 'Ginerva', 'Albus'));
            $familyTree->addFiliation(new Filiation('Harry', 'Ginerva', 'Lily'));
            $familyTree->addFiliation(new Filiation('James', 'Darcy', 'William'));
            $familyTree->addFiliation(new Filiation('Albus', 'Alice', 'Ron'));
            $familyTree->addFiliation(new Filiation('Albus', 'Alice', 'Ginny'));
        });
    }

    public function addCharacter(Character $character)
    {
        $this->characters->add($character);
    }

    public function addMarriage(Marriage $marriage)
    {
        $this->marriages->add($marriage);
    }

    public function addFiliation(Filiation $filiation)
    {
        $this->filiations->add($filiation);
    }

    public function characterExists(string $name): bool
    {
        return $this->characters->where('name', $name)->isNotEmpty();
    }

    public function findCharacter(string $name): Character
    {
        $character = $this->characters->where('name', $name)->first();

        throw_if(is_null($character), new CharacterNotFoundException($name));

        return $character;
    }

    public function findCharacters(array $names): Collection
    {
        return $this->characters->whereIn('name', $names);
    }

    public function getOffsprings(string $name): array
    {
        $role = $this->findCharacter($name)->getParentRole();

        return $this->filiations->where($role, $name)
            ->map(fn (Filiation $f) => $f->child)
            ->values()
            ->all();
    }

    public function getSons(string $name): array
    {
        return $this->findCharacters($this->getOffsprings($name))
            ->where('gender', 'Male')
            ->map(fn (Character $c) => $c->name)
            ->values()
            ->all();
    }

    public function getDaughters(string $name): array
    {
        return $this->findCharacters($this->getOffsprings($name))
            ->where('gender', 'Female')
            ->map(fn (Character $c) => $c->name)
            ->values()
            ->all();
    }

    public function findFiliation(string $name): ?Filiation
    {
        return $this->filiations->where('child', $name)->first();
    }

    public function getFather(string $name): ?string
    {
        return $this->findFiliation($name)?->father;
    }

    public function getMother(string $name): ?string
    {
        return $this->findFiliation($name)?->mother;
    }

    public function getSiblings(string $name): array
    {
        $filiation = $this->findFiliation($name);

        if ($filiation === null) return [];

        return $this->filiations
            ->where('father', $filiation->father)
            ->where('mother', $filiation->mother)
            ->where('child', '!=', $name)
            ->map(fn (Filiation $f) => $f->child)
            ->values()
            ->all();
    }

    public function getBrothers(string $name): array
    {
        return $this->findCharacters($this->getSiblings($name))
            ->where('gender', 'Male')
            ->map(fn (Character $c) => $c->name)
            ->values()
            ->all();
    }

    public function getSisters(string $name): array
    {
        return $this->findCharacters($this->getSiblings($name))
            ->where('gender', 'Female')
            ->map(fn (Character $c) => $c->name)
            ->values()
            ->all();
    }

    public function getPaternalUncles(string $name): array
    {
        $filiation = $this->findFiliation($name);

        return $this->getBrothers($filiation?->father ?? '');
    }

    public function getMaternalUncles(string $name): array
    {
        $filiation = $this->findFiliation($name);

        return $this->getBrothers($filiation?->mother ?? '');
    }

    public function getPaternalAunts(string $name): array
    {
        $filiation = $this->findFiliation($name);

        return $this->getSisters($filiation?->father ?? '');
    }

    public function getMaternalAunts(string $name): array
    {
        $filiation = $this->findFiliation($name);

        return $this->getSisters($filiation?->mother ?? '');
    }

    public function findSpouse(string $name): ?string
    {
        $role = $this->findCharacter($name)->getMarriageRole();

        $marriage = $this->marriages->where($role, $name)->first();

        if ($marriage === null) return null;

        return $role === 'husband' ? $marriage->wife : $marriage->husband;
    }

    public function findSpouses(array $names): array
    {
        return collect($names)
            ->map(fn ($name) => $this->findSpouse($name))
            ->filter()
            ->all();
    }

    public function getBrotherInLaws(string $name): array
    {
        return array_merge(
            $this->getBrothers($this->findSpouse($name) ?? ''),
            $this->findSpouses($this->getSisters($name))
        );
    }

    public function getSisterInLaws(string $name): array
    {
        return array_merge(
            $this->getSisters($this->findSpouse($name) ?? ''),
            $this->findSpouses($this->getBrothers($name))
        );
    }
}
