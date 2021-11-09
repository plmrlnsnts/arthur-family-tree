<?php

namespace Tests\Feature;

use App\Exceptions\CharacterNotFoundException;
use App\FamilyTree;
use Tests\TestCase;

class FamilyTreeTest extends TestCase
{
    protected FamilyTree $familyTree;

    public function setUp(): void
    {
        parent::setUp();

        $this->familyTree = FamilyTree::make();
    }

    public function test_it_throws_an_error_when_a_character_can_not_be_found()
    {
        $this->expectException(CharacterNotFoundException::class);

        $this->familyTree->findCharacter('Unknown');
    }

    public function test_it_can_retrieve_the_siblings_of_a_character()
    {
        $siblings = $this->familyTree->getSiblings('Bill');

        $this->assertEquals($siblings, ['Charlie', 'Percy', 'Ronald', 'Ginerva']);
    }

    public function test_it_can_retrieve_the_brothers_of_a_character()
    {
        $brothers = $this->familyTree->getBrothers('Bill');

        $this->assertEquals($brothers, ['Charlie', 'Percy', 'Ronald']);
    }

    public function test_it_can_retrieve_the_sisters_of_a_character()
    {
        $sisters = $this->familyTree->getSisters('Bill');

        $this->assertEquals($sisters, ['Ginerva']);
    }

    public function test_it_can_retrieve_the_offsprings_of_a_character()
    {
        $offsprings = $this->familyTree->getOffsprings('Queen Margret');

        $this->assertEquals($offsprings, ['Bill', 'Charlie', 'Percy', 'Ronald', 'Ginerva']);
    }

    public function test_it_can_retrieve_the_sons_of_a_character()
    {
        $sons = $this->familyTree->getSons('Queen Margret');

        $this->assertEquals($sons, ['Bill', 'Charlie', 'Percy', 'Ronald']);
    }

    public function test_it_can_retrieve_the_brother_in_laws_of_a_character()
    {
        $brotherInLaws = $this->familyTree->getBrotherInLaws('Bill');

        $this->assertEquals($brotherInLaws, ['Harry']);
    }

    public function test_it_can_retrieve_the_sister_in_laws_of_a_character()
    {
        $sisterInLaws = $this->familyTree->getSisterInLaws('Bill');

        $this->assertEquals($sisterInLaws, ['Audrey', 'Hellen']);
    }

    public function test_it_can_retrieve_the_maternal_aunts_of_a_character()
    {
        $maternalAunts = $this->familyTree->getMaternalAunts('Remus');

        $this->assertEquals($maternalAunts, ['Dominique']);
    }

    public function test_it_can_retrieve_the_paternal_aunts_of_a_character()
    {
        $paternalAunts = $this->familyTree->getPaternalAunts('Dominique');

        $this->assertEquals($paternalAunts, ['Ginerva']);
    }

    public function test_it_can_retrieve_the_maternal_uncles_of_a_character()
    {
        $maternalUncles = $this->familyTree->getMaternalUncles('Lily');

        $this->assertEquals($maternalUncles, ['Bill', 'Charlie', 'Percy', 'Ronald']);
    }

    public function test_it_can_retrieve_the_paternal_uncles_of_a_character()
    {
        $paternalUncles = $this->familyTree->getPaternalUncles('William');

        $this->assertEquals($paternalUncles, ['Albus']);
    }
}
