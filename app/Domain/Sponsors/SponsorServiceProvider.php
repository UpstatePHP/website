<?php namespace UpstatePHP\Website\Sponsors;

use Illuminate\Support\ServiceProvider;

class SponsorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setLogoImageAdapter();
    }

    protected function setLogoImageAdapter()
    {
        Logo::$image = $this->app->make('\UpstatePHP\Website\Filesystem\Image\ImageInterface');
    }
}