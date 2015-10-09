<?php namespace UpstatePHP\Website\Handlers\Commands;

use UpstatePHP\Website\Commands\ImportNewEventsCommand;

class ImportNewEventsCommandHandler
{
    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle(ImportNewEventsCommand $command)
    {
        foreach ($command->events as $event) {
            \Bus::dispatch(
                new \UpstatePHP\Website\Commands\HostEventCommand(
                    $event['title'],
                    $event['begins_at'],
                    $event['ends_at'],
                    $event['remote_id'],
                    $event['description'],
                    $event['registration_link'],
                    $event['location_name'],
                    $event['street'],
                    $event['city'],
                    $event['state'],
                    $event['zipcode'],
                    $event['latitude'],
                    $event['longitude']
                )
            );
        }
    }
}
