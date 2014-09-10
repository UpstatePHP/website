<?php namespace UpstatePHP\Website\Composers;

class OrganizationTypesComposer
{
    public function compose($view)
    {
        $types = [];

        foreach (\Config::get('site-config.organization-types') as $type) {
            $types[strtolower(str_replace(' ', '-', $type))] = $type;
        }

        asort($types);

        $view->organizationTypes = $types;
    }
}