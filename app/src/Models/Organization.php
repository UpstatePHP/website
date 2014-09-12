<?php namespace UpstatePHP\Website\Models;

use UpstatePHP\Website\Traits\SluggableTrait;

class Organization extends \Eloquent
{
    use SluggableTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->makeSlugFromDatabase($value);
    }

    public function scopeSupportersAndSponsors($query)
    {
        return $query->whereIn('type', ['supporter', 'sponsor']);
    }

}