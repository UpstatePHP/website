<?php
namespace UpstatePHP\Website\Handlers\Commands;

use UpstatePHP\Website\Filesystem\Image\ImageInterface;
use UpstatePHP\Website\Domain\Sponsors\Logo;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;

class RegisterSponsorCommandHandler
{
    /**
     * @var ImageInterface
     */
    private $imageRepository;

    public function __construct(ImageInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        // validate

        // create sponsor
        $sponsor = new Sponsor([
            'name' => $command->name,
            'url' => $command->url,
            'type' => $command->type,
            'logo' => $this->imageRepository->imageName
        ]);

        $sponsor->logo = (string) new Logo($command->logo);

        $sponsor->save();

        return $sponsor;
    }

}
