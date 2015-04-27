<?php namespace UpstatePHP\Website\Domain\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $dates = ['begins_at', 'ends_at'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

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
}