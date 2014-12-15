<?php namespace UpstatePHP\Website\Filesystem\Image\Adapters;

use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UpstatePHP\Website\Filesystem\Image\ImageInterface;

class InterventionAdapter extends AbstractBaseImageAdapter implements ImageInterface
{
    protected $image;

    protected $imageManager;

    public $imageName;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * @param File $file
     * @return $this|ImageInterface
     */
    public function setFile(File $file)
    {
        $imagick = new \Imagick();

        // Set the resolution if we're dealing with an EPS
        if ($file instanceof UploadedFile
            && $file->getClientMimeType() === 'application/postscript'
        ) {
            $imagick->setResolution(300, 300);
            $imagick->setColorspace(\Imagick::COLORSPACE_RGB);
        }

        $imagick->readImage($file->getRealPath());

        $this->image = $this->imageManager->make($imagick);

        return $this;
    }

    /**
     * @param int $width
     * @param null $height
     * @param bool $constrainAspect
     * @return $this|ImageInterface
     */
    public function resize($width, $height = null, $constrainAspect = true)
    {
        $this->image->resize($width, $height, function($constraint) use ($constrainAspect) {
            if ($constrainAspect) $constraint->aspectRatio();
        });

        return $this;
    }

    public function resizeCanvas($width, $height, $anchor = 'center', $relative = false, $bgColor = '#ffffff')
    {
        $this->image->resizeCanvas($width, $height, $anchor, $relative, $bgColor);

        return $this;
    }

    public function save()
    {
        $this->imageName = $this->hashName();
        $path = static::$destination . '/' . $this->imageName;

        $this->image->save($path, static::$quality);
    }

}