<?php

namespace Tests\Feature;

use App\Actions\GetRelationshipAction;
use App\FamilyTree;
use Tests\TestCase;

class GetRelationshipActionTest extends TestCase
{
    public function test_it_can_get_the_relatives_of_a_character()
    {
        $output = (new GetRelationshipAction(FamilyTree::make(), ['Bill', 'Brother-In-Law']))->run();

        $this->assertEquals('Harry', $output);
    }

    public function test_it_displays_none_when_there_no_relatives_can_be_found()
    {
        $output = (new GetRelationshipAction(FamilyTree::make(), ['Charlie', 'Son']))->run();

        $this->assertEquals('NONE', $output);
    }

    public function test_it_prevents_incorrect_number_of_properties()
    {
        $output = (new GetRelationshipAction(FamilyTree::make(), []))->run();

        $this->assertEquals('GET_RELATIONSHIP_FAILED', $output);

        $output = (new GetRelationshipAction(FamilyTree::make(), ['Bill']))->run();

        $this->assertEquals('GET_RELATIONSHIP_FAILED', $output);
    }

    public function test_it_prevents_getting_relatives_of_an_unknown_character()
    {
        $output = (new GetRelationshipAction(FamilyTree::make(), ['Unknown', 'Siblings']))->run();

        $this->assertEquals('PERSON_NOT_FOUND', $output);
    }

    public function test_it_prevents_getting_unsupported_relationship()
    {
        $output = (new GetRelationshipAction(FamilyTree::make(), ['Bill', 'Mother-In-Law']))->run();

        $this->assertEquals('UNSUPPORTED_RELATIONSHIP', $output);
    }
}
