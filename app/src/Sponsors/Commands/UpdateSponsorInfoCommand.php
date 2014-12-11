<?php namespace UpstatePHP\Website\Sponsors\Commands;

class UpdateSponsorInfoCommand
{
    public $name;

    public $url;

    public $type;

    public $logo;

    public $id;

    public function __construct($id, $name, $url, $type, $logo = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->type = $type;
        $this->logo = $logo;
    }
}