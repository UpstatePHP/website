<?php namespace UpstatePHP\Website\Events\Commands;

class ImportNewEventsCommand
{
    /**
     * @var array
     */
    public $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }
}