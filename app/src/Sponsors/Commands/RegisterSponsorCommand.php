<?php namespace UpstatePHP\Website\Sponsors\Commands;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterSponsorCommand
{
    public $name;

    public $url;

    public $type;

    public $logo;

    public function __construct($name, $url, $type, UploadedFile $logo = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->type = $type;
        $this->logo = $logo;
    }
}