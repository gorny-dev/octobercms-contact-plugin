<?php namespace Codeclutch\Contact\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'codeclutch_contact_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public $attachOne = [

    ];
    public function getIconOptions()
    {
        return [
            'oc-icon-adjust' => ['adjust', 'oc-icon-adjust'],
            'oc-icon-adn' => ['adn', 'oc-icon-adn'],
            'oc-icon-align-center' => ['align-center', 'oc-icon-align-center'],
            'oc-icon-align-justify' => ['align-justify', 'oc-icon-align-justify']
        ];
    }
}
