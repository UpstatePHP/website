<?php
namespace UpstatePHP\Website\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Michelf\Markdown;
use UpstatePHP\Website\Http\Controllers\Controller;
use UpstatePHP\Website\Domain\Pages\Page;

class PagesController extends Controller
{
    public function index()
    {
        $data = [
            'pages' => Page::all(),
            'pageHeader' => 'Pages'
        ];

        return view('backend.pages.index', $data);
    }

    public function create()
    {
        $data = [
            'page' => new Page,
            'pageHeader' => 'Create Page'
        ];

        return view('backend.pages.form', $data);
    }

    public function store(Request $request)
    {
        $page = Page::create($request->only('title', 'path', 'content'));

        \Cache::rememberForever($page->path, function() use ($page)
        {
            return Markdown::defaultTransform($page->content);
        });

        return redirect()->route('admin.pages.index');
    }

    public function edit($id)
    {
        $data = [
            'page' => Page::find($id),
            'pageHeader' => 'Update Page'
        ];

        return view('backend.pages.form', $data);
    }

    public function update($id, Request $request)
    {
        $page = Page::find($id);
        $page->fill($request->only('title', 'path', 'content'));
        $page->save();

        \Cache::rememberForever($page->path, function() use ($page)
        {
            return Markdown::defaultTransform($page->content);
        });

        return redirect()->route('admin.pages.index');
    }

    public function delete($id)
    {
        $page = Page::find($id);

        \Cache::forget($page->path);

        $page->delete();

        return redirect()->route('admin.pages.index');
    }

}
