<?php namespace UpstatePHP\Website\Commands;

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
