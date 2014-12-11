<?php namespace UpstatePHP\Website\Filesystem\Image\Providers;

use UpstatePHP\Website\Filesystem\Image\ImageRepository;

abstract class AbstractBaseImageProvider implements ImageRepository
{
    public static $destination;

    public static $quality = 80;

    /**
     * @return string
     */
    public function hashName()
    {
        return md5(microtime()).'.jpg';
    }

    public function removeOldFile($fileName)
    {
        @unlink(static::$destination . '/' . $fileName);
    }

}