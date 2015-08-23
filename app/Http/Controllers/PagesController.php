<?php namespace UpstatePHP\Website\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use UpstatePHP\Website\Domain\Pages\Page;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;
use UpstatePHP\Website\Domain\Videos\VideoRepository;

class PagesController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $data = [
            'supporters' => Sponsor::supportersAndSponsors()->take(4)->get()
        ];

        return view('pages.index', $data);
    }

    public function sponsors()
    {
        $sponsors = Sponsor::orderNaturally()->get();
        return view('pages.sponsors', compact('sponsors'));
    }

    public function videos(VideoRepository $videoRepository)
    {
        $videos = $videoRepository->getVideoList();
        $pageHeader = 'Videos';

        return view('pages.videos', compact('videos', 'pageHeader'));
    }

    public function postContact(
        \Illuminate\Http\Request $request,
        \UpstatePHP\Website\Services\ReCaptcha $reCaptcha,
        \Illuminate\Contracts\Queue\Queue $queue
    ) {
        $this->validate(
            $request,
            [
                'g-recaptcha-response' => 'required',
                'name' => 'required',
                'email' => 'required|email'
            ]
        );

        if ($reCaptcha->verify(
            env('RECAPTCHA_SECRET'),
            $request->get('g-recaptcha-response')
        )) {
            $queue->push(
                new \UpstatePHP\Website\Commands\SendContactEmail(
                    $request->get('subject'),
                    $request->get('name'),
                    $request->get('email'),
                    $request->get('comments', null)
                )
            );

            return response(null);
        } else {
            return response(null, \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
        }
    }

    public function catchAll($path)
    {
        $page = Page::findByPath($path);

        return view('pages.shell', compact('page'));
    }

}
