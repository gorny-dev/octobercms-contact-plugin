<?php


namespace Codeclutch\Contact\Components;

use Cms\Classes\ComponentBase;
use Codeclutch\Contact\Models\Settings;
use Codeclutch\Base\Models\Settings as BaseSettings;
use Illuminate\Support\Facades\Lang;

class CompanyInformation extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => Lang::get('codeclutch.contact::lang.plugin.company_information.name'),
            'description' => Lang::get('codeclutch.contact::lang.plugin.company_information.description')
        ];
    }

    public function onRun()
    {
        $settings = Settings::instance();

        /* Basic information */
        $information['company_name'] = $settings->company_name;
        $information['email'] = $settings->email;
        $information['phone'] = $settings->phone;

        /* Take logo from 'Base' plugin */
        $information['logo'] = BaseSettings::instance()->logo;

        /* Address */
        $information['street'] = $settings->address_street;
        $information['number'] = $settings->address_number;
        $information['post_code'] = $settings->address_postcode;
        $information['city'] = $settings->address_city;
        $information['country'] = $settings->country;

        /* Receivers */
        $information['receivers'] = $settings->receivers;

        $this->page['information'] = $information;

        /* __SELF__ in .htm bugs, used classic $this->page instruction */
        $this->page['are_receivers'] = $this->property('are_receivers');
        $this->page['are_icons'] = $this->property('are_icons');
    }

    public function defineProperties()
    {
        return [
            'are_icons' => [
                'title'             => Lang::get('codeclutch.contact::lang.plugin.components
                .company_information.are_icons.name'),
                'description'       => Lang::get('codeclutch.contact::lang.plugin.components
                .company_information.are_icons.description'),
                'default'           => true,
                'type'              => 'boolean',
            ],
            'are_receivers' => [
                'title'             => Lang::get('codeclutch.contact::lang.plugin.components
                .company_information.are_receivers.name'),
                'description'       => Lang::get('codeclutch.contact::lang.plugin.components
                .company_information.are_receivers.description'),
                'default'           => false,
                'type'              => 'boolean',
            ],
        ];
    }
}
