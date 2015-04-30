<?php namespace UpstatePHP\Website\Domain\Events\Providers;

use Carbon\Carbon;
use UpstatePHP\Website\Domain\Events\Event;
use UpstatePHP\Website\Domain\Events\EventRepository;

abstract class EloquentProvider implements EventRepository
{
    public function nextEvent()
    {
        $query = $this->newQuery();
        $query->where('begins_at', '>=', Carbon::now('America/New_York'));

        return $query->first();
    }

    public function getEvents($perPage = null)
    {
        $query = $this->newQuery();
        $query->orderBy('begins_at', 'desc');
        return $query->paginate($perPage);
    }

    protected function newQuery()
    {
        return (new Event)->newQuery();
    }

}