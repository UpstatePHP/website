<?php
namespace UpstatePHP\Website\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Routing\Route as Route;

class MenuComposer
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
        $menu = $view->app->make('menu');

        foreach ($menu as $key => $item) {
            $item['link'] = array_get($item, 'link', null)
                ?: (array_get($item, 'route', false)
                    ? route($item['route'])
                    : '/'
                );
            $item['title'] = array_get($item, 'title', Str::title($key));
            $item['isActive'] = (isset($item['route']) && $this->route->getName() === $item['route'])
                || strpos(
                    $this->route->getUri(),
                    $key
                ) !== false;
            $menu->put($key, $item);
        }

        $menu->sortBy('order');
        $view->menu = $view->app->make('menu');
    }
}
