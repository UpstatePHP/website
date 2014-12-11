<?php namespace UpstatePHP\Website\Sponsors;

class Sponsor extends \Eloquent
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeSupportersAndSponsors($query)
    {
        return $query->whereIn('type', ['supporter', 'sponsor'])
                     ->orderBy(\DB::raw('RAND()'));
    }

}