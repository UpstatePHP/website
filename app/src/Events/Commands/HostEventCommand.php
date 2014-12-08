<?php namespace UpstatePHP\Website\Events\Commands;

class HostEventCommand
{
    public $title;
    public $description;
    public $registration_link;
    public $remote_id;
    public $begins_at;
    public $ends_at;
    public $venue;

    public function __construct(
        $title,
        $description,
        $registration_link,
        $remote_id,
        $begins_at,
        $ends_at,
        $venue
    ) {

        $this->title = $title;
        $this->description = $description;
        $this->registration_link = $registration_link;
        $this->remote_id = $remote_id;
        $this->begins_at = $begins_at;
        $this->ends_at = $ends_at;
        $this->venue = $venue;
    }
}