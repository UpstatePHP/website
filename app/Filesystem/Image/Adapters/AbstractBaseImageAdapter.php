<?php namespace UpstatePHP\Website\Filesystem\Image\Adapters;

use UpstatePHP\Website\Filesystem\Image\ImageInterface;

abstract class AbstractBaseImageAdapter implements ImageInterface
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