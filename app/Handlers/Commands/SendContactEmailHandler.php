<?php namespace UpstatePHP\Website\Handlers\Commands;

use UpstatePHP\Website\Commands\SendContactEmail;

use Illuminate\Queue\InteractsWithQueue;
use UpstatePHP\Website\Services\Contact;

class SendContactEmailHandler
{
    /**
     * @var Contact
     */
    private $contactService;

    /**
     * Create the command handler.
     *
     * @return void
     */
    public function __construct(Contact $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Handle the command.
     *
     * @param  SendContactEmail $command
     * @return void
     */
    public function handle(SendContactEmail $command)
    {
        $this->contactService->send([
            'name'     => $command->name,
            'email'    => $command->email,
            'subject'  => $command->subject,
            'comments' => $command->comments
        ]);
    }

}
