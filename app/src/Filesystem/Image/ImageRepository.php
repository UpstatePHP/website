<?php namespace UpstatePHP\Website\Filesystem\Image;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageRepository
{
    /**
     * @param File $file
     * @return self
     */
    public function setFile(File $file);

    /**
     * @param int $width
     * @param int|null $height
     * @param boolean $constrainAspect
     * @return self
     */
    public function resize($width, $height = null, $constrainAspect = true);

    public function save();

    /**
     * @return string
     */
    public function hashName();
}