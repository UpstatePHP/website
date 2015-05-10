<?php namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;
use UpstatePHP\Website\Domain\Sponsors\Logo;

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
