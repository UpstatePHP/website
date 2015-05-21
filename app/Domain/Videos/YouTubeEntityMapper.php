<?php
namespace UpstatePHP\Website\Domain\Videos;

use stdClass;

class YouTubeEntityMapper
{
    public static function map(stdClass $entity)
    {
        return [
            'video_id' => $entity->contentDetails->videoId,
            'title' => $entity->snippet->title,
            'description' => $entity->snippet->description,
            'published_at' => date('Y-m-d H:i:s', strtotime($entity->snippet->publishedAt)),
            'position' => $entity->snippet->position
        ];
    }
}
