<?php namespace UpstatePHP\Website\Sponsors\Commands;

use Laracasts\Commander\CommandHandler;
use UpstatePHP\Website\Filesystem\Image\ImageRepository;
use UpstatePHP\Website\Sponsors\Sponsor;

class UpdateSponsorInfoCommandHandler implements CommandHandler
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

        // find sponsor
        $sponsor = Sponsor::find($command->id);

        // create file
        if (! is_null($command->logo)) {
            $oldFile = $sponsor->logo;

            $this->imageRepository->setFile($command->logo)
                ->resize(600, 341)->save();

            $sponsor->logo = $this->imageRepository->imageName;

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