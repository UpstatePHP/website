<?php namespace UpstatePHP\Website\Commands;

use UpstatePHP\Website\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendContactEmail extends Command implements ShouldBeQueued
{

    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var null
     */
    public $comments;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($subject, $name, $email, $comments = null)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->comments = $comments;
    }

}
