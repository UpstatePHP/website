<?php namespace UpstatePHP\Website\Handlers\Commands;

use UpstatePHP\Website\Commands\HostEventCommand;
use UpstatePHP\Website\Domain\Events\Event as EventModel;

class HostEventCommandHandler
{
    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle(HostEventCommand $command)
    {
        $event = new EventModel([
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

        $event->sponsors()->sync($command->sponsors);

        return $event;
    }

}
