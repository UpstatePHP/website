<?php namespace UpstatePHP\Website\Composers;

class SponsorTypesComposer
{
    public function compose($view)
    {
        $types = [];

        foreach (\Config::get('site-config.sponsor-types') as $type) {
            $types[strtolower(str_replace(' ', '-', $type))] = $type;
        }

        asort($types);

        $view->sponsorTypes = $types;
    }
}