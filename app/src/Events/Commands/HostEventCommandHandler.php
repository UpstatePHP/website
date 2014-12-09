<?php namespace UpstatePHP\Website\Events\Commands;

use UpstatePHP\Website\Events\Event;
use Laracasts\Commander\CommandHandler;

class HostEventCommandHandler implements CommandHandler
{
    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $event = new Event([
            'title' => $command->title,
            'description' => $command->description,
            'registration_link' => $command->registration_link,
            'remote_id' => $command->remote_id,
            'begins_at' => $command->begins_at,
            'ends_at' => $command->ends_at,
            'location_name' => $command->location_name,
            'street' => $command->street,
            'city' => $command->city,
            'state' => $command->state,
            'zipcode' => $command->zipcode,
            'latitude' => $command->latitude,
            'longitude' => $command->longitude
        ]);

        $event->save();

        return $event;
    }

}