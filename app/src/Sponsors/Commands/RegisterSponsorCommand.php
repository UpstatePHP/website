<?php namespace UpstatePHP\Website\Sponsors\Commands;

class RegisterSponsorCommand
{
    public $name;

    public $url;

    public $type;

    public $logo;

    public function __construct($name, $url, $type, $logo = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->type = $type;
        $this->logo = $logo;
    }
}