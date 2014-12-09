<?php namespace UpstatePHP\Website\Events\Commands;

class HostEventCommand
{
    public $title;
    public $description;
    public $registration_link;
    public $remote_id;
    public $begins_at;
    public $ends_at;
    public $location_name;
    public $street;
    public $city;
    public $state;
    public $zipcode;
    public $latitude;
    public $longitude;

    public function __construct(
        $title,
        $remote_id,
        $begins_at,
        $ends_at,
        $description = null,
        $registration_link = null,
        $location_name = null,
        $street = null,
        $city = null,
        $state = null,
        $zipcode = null,
        $latitude = null,
        $longitude = null
    ) {

        $this->title = $title;
        $this->description = $description;
        $this->registration_link = $registration_link;
        $this->remote_id = $remote_id;
        $this->begins_at = $begins_at;
        $this->ends_at = $ends_at;
        $this->location_name = $location_name;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}