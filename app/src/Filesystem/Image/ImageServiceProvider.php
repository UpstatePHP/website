<?php namespace UpstatePHP\Website\Filesystem\Image;

use Illuminate\Support\ServiceProvider;
use UpstatePHP\Website\Filesystem\Image\Providers\AbstractBaseImageProvider;
use UpstatePHP\Website\Filesystem\Image\Providers\InterventionProvider;

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

        AbstractBaseImageProvider::$destination = public_path() . '/uploads';

        $this->app->bind('\UpstatePHP\Website\Filesystem\Image\ImageRepository', function($app)
        {
            return new InterventionProvider($app['image']);
        });
    }

    protected function setImagineDriver()
    {
        $this->app['image']->configure(['driver' => 'imagick']);
    }
}