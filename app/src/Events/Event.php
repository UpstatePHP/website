<?php namespace UpstatePHP\Website\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $dates = ['begins_at', 'ends_at'];

    protected $fillable = ['title', 'description', 'registration_link', 'begins_at', 'ends_at', 'venue_id', 'remote_id'];

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