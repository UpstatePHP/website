<?php namespace UpstatePHP\Website\Domain\Sponsors;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeSupportersAndSponsors($query)
    {
        return $query->whereIn('type', ['supporter', 'sponsor'])
                     ->orderBy(\DB::raw('RAND()'));
    }

    public function scopeOrderNaturally($query, $direction = 'ASC')
    {
        return $query->orderBy(\DB::raw(
            "TRIM(
                LEADING 'a ' FROM TRIM(
                    LEADING 'an ' FROM TRIM(
                        LEADING 'the ' FROM LOWER(`name`)
                    )
                )
            )"
        ), $direction);
    }

    public function events()
    {
        return $this->belongsToMany(
            'UpstatePHP\Website\Domain\Events\Event',
            'event_sponsors',
            'sponsor_id',
            'event_id'
        );
    }

}
