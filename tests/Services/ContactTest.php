<?php
namespace UpstatePHP\Website\Tests\Services;

use \Mockery as m;
use PHPUnit_Framework_TestCase;
use UpstatePHP\Website\Services\Contact;

class ContactTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testToAddressWithoutTag()
    {
        $this->assertSame(
            'upstatephp@gmail.com',
            $this->getContactService()->getToAddress()
        );
    }

    public function testToAddressWithTag()
    {
        $this->assertSame(
            'upstatephp+sponsorship@gmail.com',
            $this->getContactService()->getToAddress('sponsorship')
        );
    }

    public function testSubjectWithoutPostScript()
    {
        $this->assertSame(
            Contact::$defaultSubject,
            $this->getContactService()->getSubject()
        );
    }

    public function testSubjectWithPostScript()
    {
        $this->assertSame(
            Contact::$defaultSubject . ' - General Inquiry',
            $this->getContactService()->getSubject('general-inquiry')
        );
    }

    private function getMockMailer()
    {
        $mailer = m::mock('Illuminate\Contracts\Mail\Mailer');
        $mailer->shouldReceive('send');
        $mailer->shouldReceive('queue');

        return $mailer;
    }

    private function getContactService()
    {
        return new Contact($this->getMockMailer());
    }
}
