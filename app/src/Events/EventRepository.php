<?php namespace UpstatePHP\Website\Events;

use UpstatePHP\Website\Events\Commands\HostEventCommand;

interface EventRepository
{
    public function fetchRemoteEvents($sinceId = null);

    public function importNewRemoteEvents();
}