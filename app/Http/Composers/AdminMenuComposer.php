<?php
namespace UpstatePHP\Website\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Routing\Route as Route;

class AdminMenuComposer
{
    /**
     * @var Route
     */
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function compose(View $view)
    {
        $menu = $view->app->make('admin-menu');

        foreach ($menu as $key => $item) {
            $item['link'] = array_get($item, 'link', null)
                ?: (array_get($item, 'route', false)
                    ? route($item['route'])
                    : '/'
                );
            $item['title'] = array_get($item, 'title', Str::title($key));
            $item['isActive'] = isset($item['route']) && $this->route->getName() === $item['route'];
            $menu->put($key, $item);
        }

        $menu->sortBy('order');
        $view->menu = $menu;
    }
}