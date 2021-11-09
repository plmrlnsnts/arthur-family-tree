<?php

namespace Tests\Feature;

use App\Actions\AddChildAction;
use App\FamilyTree;
use Tests\TestCase;

class AddChildActionTest extends TestCase
{
    public function test_it_can_add_a_child_to_a_mother()
    {
        $output = (new AddChildAction(FamilyTree::make(), ['Flora', 'Lola', 'Female']))->run();

        $this->assertEquals('CHILD_ADDED', $output);
    }

    public function test_it_prevents_incorrect_number_of_properties()
    {
        $output = (new AddChildAction(FamilyTree::make(), []))->run();

        $this->assertEquals('CHILD_ADDITION_FAILED', $output);

        $output = (new AddChildAction(FamilyTree::make(), ['Flora']))->run();

        $this->assertEquals('CHILD_ADDITION_FAILED', $output);

        $output = (new AddChildAction(FamilyTree::make(), ['Flora', 'Lola']))->run();

        $this->assertEquals('CHILD_ADDITION_FAILED', $output);
    }

    public function test_it_prevents_adding_child_to_an_unknown_mother()
    {
        $output = (new AddChildAction(FamilyTree::make(), ['Unknown', 'Lola', 'Female']))->run();

        $this->assertEquals('PERSON_NOT_FOUND', $output);
    }

    public function test_it_prevents_adding_child_to_a_mother_without_a_spouse()
    {
        $output = (new AddChildAction(FamilyTree::make(), ['Lily', 'Lola', 'Female']))->run();

        $this->assertEquals('PERSON_NOT_FOUND', $output);
    }

    public function test_it_prevents_adding_child_to_a_male_character()
    {
        $output = (new AddChildAction(FamilyTree::make(), ['Bill', 'Lola', 'Female']))->run();

        $this->assertEquals('CHILD_ADDITION_FAILED', $output);
    }
}
