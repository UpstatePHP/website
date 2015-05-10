<?php namespace UpstatePHP\Website\Handlers\Commands;

use UpstatePHP\Website\Filesystem\Image\ImageInterface;
use UpstatePHP\Website\Domain\Sponsors\Logo;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;

class UpdateSponsorInfoCommandHandler
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

        // find sponsor
        $sponsor = Sponsor::find($command->id);

        // create file
        if (! is_null($command->logo)) {
            $oldFile = $sponsor->logo;

            $sponsor->logo = (string) new Logo($command->logo);

            $this->imageRepository->removeOldFile($oldFile);
        }

        // update sponsor
        $sponsor->fill([
            'name' => $command->name,
            'url' => $command->url,
            'type' => $command->type,
        ]);

        $sponsor->save();

        return $sponsor;
    }
}
