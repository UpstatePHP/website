<?php namespace UpstatePHP\Website\Models;

class Venue extends \Eloquent
{
    public function events()
    {
        return $this->hasMany('\UpstatePHP\Website\Models\Event');
    }
}