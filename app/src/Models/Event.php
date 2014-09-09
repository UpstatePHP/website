<?php namespace UpstatePHP\Website\Models;

use Carbon\Carbon;

class Event extends \Eloquent {

    protected $dates = ['begins_at', 'ends_at'];

	protected $fillable = ['title', 'description', 'link', 'begins_at', 'ends_at'];

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

    public function venue()
    {
        return $this->belongsTo('\UpstatePHP\Website\Models\Venue');
    }
}