<?php namespace UpstatePHP\Website\Models;

use Geocode;

class Venue extends \Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        self::saving(function($venue)
        {
            if ($response = Geocode::make()->address($venue->address)) {
                $venue->latitude = $response->latitude();
                $venue->longitude = $response->longitude();
            }
        });
    }

    public function events()
    {
        return $this->hasMany('\UpstatePHP\Website\Models\Event');
    }

    public function getAddressAttribute()
    {
        $address = '';

        if (! is_null($this->getAttribute('street'))) {
            $address .= ' ' . $this->getAttribute('street');
        }

        $address .= ' ' . $this->getAttribute('city');
        $address .= ' ' . $this->getAttribute('state');

        if (! is_null($this->getAttribute('zipcode'))) {
            $address .= ' ' . $this->getAttribute('zipcode');
        }

        return trim($address);
    }
}