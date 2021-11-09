<?php

namespace App\Actions;

class UnsupportedMeetTheFamilyAction extends MeetTheFamilyAction
{
    public static function signature(): string
    {
        return '';
    }

    public function run(): string
    {
        return 'UNSUPPORTED_ACTION';
    }
}
