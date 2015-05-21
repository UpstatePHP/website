<?php
namespace UpstatePHP\Website\Http\Composers;

use Illuminate\Contracts\View\View;
use UpstatePHP\Website\Domain\Videos\VideoRepository;

class LatestVideoComposer
{
    /**
     * @var VideoRepository
     */
    private $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function compose(View $view)
    {
        $view->latestVideo = $this->videoRepository->getLatestVideo();
    }
}
