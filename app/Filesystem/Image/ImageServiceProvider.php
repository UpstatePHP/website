<?php namespace UpstatePHP\Website\Filesystem\Image;

use Illuminate\Support\ServiceProvider;
use UpstatePHP\Website\Filesystem\Image\Adapters\AbstractBaseImageAdapter;
use UpstatePHP\Website\Filesystem\Image\Adapters\InterventionAdapter;

class ImageServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setImagineDriver();

        AbstractBaseImageAdapter::$destination = public_path() . '/uploads';

        $this->app->bind('\UpstatePHP\Website\Filesystem\Image\ImageInterface', function($app)
        {
            return new InterventionAdapter($app['image']);
        });
    }

    protected function setImagineDriver()
    {
        $this->app['image']->configure(['driver' => 'imagick']);
    }
}