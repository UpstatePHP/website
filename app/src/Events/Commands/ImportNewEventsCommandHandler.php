<?php namespace UpstatePHP\Website\Events\Commands;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\CommandHandler;
use UpstatePHP\Website\Events\EventRepository;

class ImportNewEventsCommandHandler implements CommandHandler
{
    use CommanderTrait;

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        foreach ($command->events as $event) {
            $event = $this->execute(
                'UpstatePHP\Website\Events\Commands\HostEventCommand',
                $event
            );
        }
    }
}