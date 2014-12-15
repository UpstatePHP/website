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
        //$this->checkBorderColor();
        $this->save();
    }

    protected function resize()
    {
        $resizeWidth = static::$maxWidth;
        $resizeHeight = static::$maxHeight;

        // Check the border pixels. If they don't match
        // the background, we need a margin.
        $colors = [];
        $bounds = [
            [0, $this->image()->width()],
            [$this->image()->width(), $this->image()->height()],
            [$this->image()->width(), 0],
            [$this->image()->height(), 0]
        ];

        foreach ($bounds as $bound){
            foreach (range($bound[0], $bound[1]) as $pixel) {
                $colors[] = $this->image()->pickColor($bound[0], $pixel, 'hex');
            }
        }

        $colors = array_unique($colors);

        // If there is more than one color present (meaning a different color from the background)
        // we definitely need a margin because our image hits the edge somewhere.
        if (count($colors) > 1) {
            $resizeWidth -= (static::$margin * 2);
            $resizeHeight -= (static::$margin * 2);
        }
        // end border check

        $this->image()->resize($resizeWidth, $resizeHeight);

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