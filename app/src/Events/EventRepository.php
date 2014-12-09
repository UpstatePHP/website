<?php namespace UpstatePHP\Website\Events;

interface EventRepository
{
    public function nextEvent();

    public function allEvents($perPage = null);

    public function fetchRemoteEvents($sinceId = null);

    public function importNewRemoteEvents();
}