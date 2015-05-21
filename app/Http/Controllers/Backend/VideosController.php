<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use Illuminate\Http\Request;
use UpstatePHP\Website\Domain\Videos\VideoRepository;
use UpstatePHP\Website\Http\Controllers\Controller;
use UpstatePHP\Website\Domain\Videos\Video;

class VideosController extends Controller
{
    /**
     * @var VideoRepository
     */
    private $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function index()
    {
        $data = [
            'videos' => $this->videoRepository->getVideoList(),
            'pageHeader' => 'Videos'
        ];

        return view('backend.videos.index', $data);
    }

    public function edit($id)
    {
        $data = [
            'video' => Video::find($id),
            'pageHeader' => 'Update Video'
        ];

        return view('backend.videos.form', $data);
    }

    public function update($id, Request $request)
    {

        return redirect()->route('admin.sponsors.index');
    }

    public function delete($id)
    {
        Video::find($id)->delete();
        flash()->success('The video was successfully removed.');

        return redirect()->route('admin.videos.index');
    }

    public function import()
    {
        $imported = $this->videoRepository->importFromYouTube();

        flash()->success(sprintf(
            '%d videos were successfully imported.',
            $imported->count()
        ));

        return response(null);
    }

}
