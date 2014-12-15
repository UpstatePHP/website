<?php namespace UpstatePHP\Website\Sponsors;

use Symfony\Component\HttpFoundation\File\File;

class Logo
{
    public static $maxWidth = 600;

    public static $maxHeight = 341;

    public static $margin = 20;

    /**
     * @var \UpstatePHP\Website\Filesystem\Image\ImageInterface
     */
    public static $image;

    public function __construct(File $file)
    {
        $this->image()->setFile($file);
        $this->resize();
        $this->save();
    }

    protected function resize()
    {
        $this->image()->resize(static::$maxWidth, static::$maxHeight);

        $this->image()->resizeCanvas(
            static::$maxWidth,
            static::$maxHeight,
            'center',
            false,
            '#ffffff'
        );
    }

    protected function save()
    {
        $this->saved = true;
        $this->image()->save();
    }

    protected function image()
    {
        return static::$image;
    }

    public function __toString()
    {
        return $this->image()->imageName;
    }
}