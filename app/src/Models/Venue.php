<?php namespace UpstatePHP\Website\Models;

use Geotools;

class Venue extends \Eloquent
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        self::saving(function($venue)
        {
            $geoInfo = Geotools::geocode($venue->address);

            dd($geoInfo);
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