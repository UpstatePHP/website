<?php namespace UpstatePHP\Website\Commands;

class UpdateHostedEventCommand extends Command
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
    public $id;

    public function __construct(
        $id,
        $title,
        $begins_at,
        $ends_at,
        $remote_id = null,
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
        $this->id = $id;
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