<?php
namespace UpstatePHP\Website\Http\Composers;

use Illuminate\Contracts\View\View;
use UpstatePHP\Website\Domain\Sponsors\Sponsor;

class SponsorsListComposer
{
    public function compose(View $view)
    {
        $sponsors = [];
        foreach (Sponsor::all() as $sponsor) {
            $sponsors[$sponsor->id] = $sponsor->name;
        }

        $view->sponsors = $sponsors;
    }
}
