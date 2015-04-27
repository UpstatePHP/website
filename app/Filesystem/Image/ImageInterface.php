<?php namespace UpstatePHP\Website\Filesystem\Image;


use Symfony\Component\HttpFoundation\File\File;

interface ImageInterface
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
     * @param string $fileName
     * @return mixed
     */
    public function removeOldFile($fileName);

    /**
     * @param int $width
     * @param int $height
     * @param string $anchor
     * @param bool $relative
     * @param string $bgColor
     * @return mixed
     */
    public function resizeCanvas($width, $height, $anchor = 'center', $relative = false, $bgColor = '#ffffff');

    /**
     * @param int $x
     * @param int $y
     * @param string $format array\rgb\rgba\hex\int
     * @return mixed
     */
    public function pickColor($x, $y, $format = 'rgb');

    /**
     * @return int
     */
    public function width();

    /**
     * @return int
     */
    public function height();

    /**
     * @return string
     */
    public function hashName();
}