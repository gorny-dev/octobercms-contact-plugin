<?php namespace Codeclutch\Contact;

use Backend;
use System\Classes\PluginBase;
use Lang;

/**
 * contact Plugin Information File
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => Lang::get('codeclutch.contact::lang.plugin.name'),
            'description' => Lang::get('codeclutch.contact::lang.plugin.description'),
            'author'      => Lang::get('codeclutch.contact::lang.plugin.author'),
            'icon'        => 'icon-at'
        ];
    }

    public function registerSettings()
    {
        return [
            'base' => [
                'label' => Lang::get('codeclutch.contact::lang.plugin.name'),
                'description' => Lang::get('codeclutch.contact::lang.plugin.description'),
                'category' => Lang::get('codeclutch.contact::lang.plugin.author'),
                'icon' => 'icon-at',
                'order' => 2,
                'class' => 'Codeclutch\Contact\Models\Settings'
            ]
        ];
    }

}

