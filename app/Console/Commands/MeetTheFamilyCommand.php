<?php

namespace App\Console\Commands;

use App\Actions\AddChildAction;
use App\Actions\GetRelationshipAction;
use App\Actions\UnsupportedMeetTheFamilyAction;
use App\FamilyTree;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MeetTheFamilyCommand extends Command
{
    protected $signature = 'meet-the-family {--file=meet-the-family}';

    protected $description = 'Meet the family of King Arthur and Queen Margaret.';

    protected FamilyTree $familyTree;

    protected $actions = [
        AddChildAction::class,
        GetRelationshipAction::class,
    ];

    public function handle()
    {
        $this->familyTree = FamilyTree::make();

        foreach ($this->commandsFromFile() as $command) {
            $parts = explode(' ', $command);

            $action = collect($this->actions)->first(
                fn ($action) => $action::signature() == $parts[0],
                fn () => UnsupportedMeetTheFamilyAction::class
            );

            /** @var \App\Actions\MeetTheFamilyAction **/
            $instance = (new $action($this->familyTree, array_splice($parts, 1)));

            $this->line($instance->run());
        }
    }

    protected function commandsFromFile(): array
    {
        $contents = File::get(base_path($this->option('file')));

        return array_filter(explode(PHP_EOL, $contents));
    }
}
