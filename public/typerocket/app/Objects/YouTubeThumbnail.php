<?php
namespace TypeRocket\Objects;

class YouTubeThumbnail
{
    protected $sizes = [
        'default' => [
            'uri' => 'default',
            'height' => 90,
            'width' => 120
        ],
        'medium' => [
            'uri' => 'mqdefault',
            'height' => 180,
            'width' => 320
        ],
        'high' => [
            'uri' => 'hqdefault',
            'height' => 360,
            'width' => 480
        ],
        'standard' => [
            'uri' => 'sddefault',
            'height' => 480,
            'width' => 640
        ],
        'maxres' => [
            'uri' => 'maxresdefault',
            'height' => 720,
            'width' => 1280
        ]
    ];

    protected $imgUrl = 'https://i.ytimg.com/vi/%s/%s.jpg';

    protected $videoId;

    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    public function url($size = 'default')
    {
        return sprintf(
            $this->imgUrl,
            $this->videoId,
            $this->sizes[$size]['uri']
        );
    }

    public function getAttributes($size = 'default')
    {
        return [
            'url' => $this->url($size),
            'height' => $this->sizes[$size]['height'],
            'width' => $this->sizes[$size]['width']
        ];
    }

    public function __toString()
    {
        list($url, $height, $width) = $this->getAttributes();

        return sprintf(
            '<img src="%s" height="%s" width="%s" />',
            $url,
            $height,
            $width
        );
    }
}
