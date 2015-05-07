<?php
namespace UpstatePHP\Website\Http\Composers;

use Illuminate\Config\Repository as Config;

class SponsorTypesComposer
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function compose($view)
    {
        $types = [];
        foreach ($this->config->get('site-config.sponsor-types') as $type) {
            $types[strtolower(str_replace(' ', '-', $type))] = $type;
        }
        asort($types);
        $view->sponsorTypes = $types;
    }
}
