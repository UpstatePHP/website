<?php namespace UpstatePHP\Website\Models;

use Carbon\Carbon;
use UpstatePHP\Website\Traits\SluggableTrait;

class Event extends \Eloquent {

    use SluggableTrait;

    protected $dates = ['begins_at', 'ends_at'];

	protected $fillable = ['title', 'description', 'link', 'begins_at', 'ends_at', 'venue_id'];

    public static function next()
    {
        return static::where('begins_at', '>=', Carbon::now())->first();
    }

    public function setBeginsAtAttribute($value)
    {
        $this->attributes['begins_at'] = new Carbon($value);
    }

    public function setEndsAtAttribute($value)
    {
        $this->attributes['ends_at'] = new Carbon($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->makeSlugFromDatabase($value);
    }

    public function venue()
    {
        return $this->belongsTo('\UpstatePHP\Website\Models\Venue');
    }
}