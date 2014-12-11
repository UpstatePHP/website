<?php namespace UpstatePHP\Website\Sponsors\Commands;

use Laracasts\Commander\CommandHandler;
use UpstatePHP\Website\Filesystem\Image\ImageRepository;
use UpstatePHP\Website\Sponsors\Sponsor;

class RegisterSponsorCommandHandler implements CommandHandler
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
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

        // create file
        $this->imageRepository->setFile($command->logo)
            ->resize(300)->save();

        // create sponsor
        $sponsor = new Sponsor([
            'name' => $command->name,
            'url' => $command->url,
            'type' => $command->type,
            'logo' => $this->imageRepository->imageName
        ]);

        $sponsor->save();

        return $sponsor;
    }

}