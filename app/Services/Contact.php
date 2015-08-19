<?php
namespace UpstatePHP\Website\Services;

use Illuminate\Contracts\Mail\Mailer;

class Contact
{
    public static $defaultSubject = 'Contact From UpstatePHP.com';

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(array $data)
    {
        $this->mailer->send(
            'emails.contact-request',
            $data,
            function($message) use ($data)
            {
                $message->to($this->getToAddress($data['subject']))
                    ->subject($this->getSubject($data['subject']))
//                    ->from($data['email'], $data['name'])
//                    ->sender($data['email'], $data['name'])
                    ->replyTo($data['email'], $data['name']);
            }
        );
    }

    public function getToAddress($tag = null)
    {
        $to = 'upstatephp';

        if (! is_null($tag)) {
            $to .= '+' . $tag;
        }

        $to .= '@gmail.com';

        return $to;
    }

    public function getSubject($postScript = null)
    {
        $subject = static::$defaultSubject;

        if (! is_null($postScript)) {
            $subject .= ' - ';
            $subject .= ucwords(
                preg_replace('/\W+/', ' ', $postScript)
            );
        }

        return $subject;
    }
}
