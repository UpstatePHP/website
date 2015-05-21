<?php
namespace UpstatePHP\Website\Domain\Videos;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'video_id',
        'position',
        'title',
        'description',
        'published_at'
    ];

    protected $thumbnail = null;

    const CREATED_AT = 'imported_at';

    public function getDates()
    {
        return ['published_at', 'imported_at', 'updated_at'];
    }

    public function getThumbnailAttribute()
    {
        if (is_null($this->thumbnail)) {
            $this->thumbnail = new YouTubeThumbnail($this->getAttribute('video_id'));
        }

        return $this->thumbnail;
    }
}
