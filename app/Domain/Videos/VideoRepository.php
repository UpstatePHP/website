<?php
namespace UpstatePHP\Website\Domain\Videos;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;

class VideoRepository
{
    protected $playlistId;

    protected $youtube;

    public function __construct(Application $app)
    {
        $this->playlistId = $app['config']->get('youtube.playlists.uploads');
        $this->youtube = $app['youtube'];
    }

    /**
     * @return Collection
     */
    public function importFromYouTube()
    {
        $pageToken = true;
        $videos = new Collection;

        do {
            $result = $this->youtube->getPlaylistItemsByPlaylistId(
                $this->playlistId,
                $pageToken,
                50
            );

            $results = (new Collection($result['results']))->map(function($item)
            {
                return YouTubeEntityMapper::map($item);
            });

            $videos = $videos->merge($results);
            $pageToken = $result['info']['nextPageToken'];
        } while ($pageToken);

        $existingVideos = Video::all()->keyBy('video_id')->toArray();

        $imported = new Collection;

        foreach (array_diff_key($videos->keyBy('video_id')->toArray(), $existingVideos) as $video) {
            $imported->push(Video::create($video));
        }

        return $imported;
    }

    public function getVideoList()
    {
        return Video::query()->orderBy('published_at', 'desc')->get();
    }
}
