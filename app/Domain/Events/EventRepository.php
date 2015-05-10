<?php namespace UpstatePHP\Website\Domain\Events;

interface EventRepository
{
    public function nextEvent();

    public function getEvents($perPage = null);

    public function fetchRemoteEvents($sinceId = null);

    public function importNewRemoteEvents();
}