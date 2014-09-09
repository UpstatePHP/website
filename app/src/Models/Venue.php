<?php namespace UpstatePHP\Website\Models;

class Venue extends \Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function events()
    {
        return $this->hasMany('\UpstatePHP\Website\Models\Event');
    }
}