<?php


namespace Codeclutch\Contact\Components;

use Cms\Classes\ComponentBase;
use Codeclutch\Contact\Models\Settings;
use Lang;

class SocialIcons extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => Lang::get('codeclutch.contact::lang.plugin.social_icons.name'),
            'description' => Lang::get('codeclutch.contact::lang.plugin.social_icons.description')
        ];
    }

    public function getIconsArray()
    {
        return Settings::instance()->social_media;
    }
}
