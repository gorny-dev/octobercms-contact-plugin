<?php

namespace Codeclutch\Contact\Components;

use Cms\Classes\ComponentBase;
use Codeclutch\Contact\Models\Message;
use Illuminate\Support\Arr;
use Validator;
use Lang;
use Input;
use Flash;
use Session;
use Codeclutch\Contact\Models\Settings;

class ContactForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => Lang::get('codeclutch.contact::lang.plugin.contact_form.name'),
            'description' => Lang::get('codeclutch.contact::lang.plugin.contact_form.description')
        ];
    }

    public function onRender()
    {
        /* Get custom fields for view */
        $this->page['custom_fields'] = Settings::instance()->custom_fields;

        /* Get the message after sending message */
        $this->page['msg'] = \Session::get('msg');
    }

    public function onSend()
    {
        /* Basic values */
        $basics = [
            'name' => 'name',
            'email' => 'email',
            'content' => 'content',
        ];

        /* Received data array */
        $received_data = [];
        foreach ($basics as $field) {
            $received_data[$field] = Input::get($field);
        }

        /* Add values from custom fields to $received_data array */
        foreach (Settings::instance()->custom_fields as $field) {
            $received_data[$field['fields_name']] = Input::get($field['fields_name'], null);
        }

        /* Create a new message model */
        $message = new Message();
        $rules = $message->rules;
        foreach (Settings::instance()->custom_fields as $field) {
            if ($field['is_required']) {
                $rules[$field['fields_name']] = 'required';
            }
        }

        /* Create a validator */
        $validator = Validator::make($received_data, $rules);

        /* If validation is not correct */
        if ($validator->fails()) {
            return \Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        /* Add values from $received_data to Message model */
        if ($received_data) {
            foreach ($received_data as $field => $value) {
                if (Arr::has($basics, $field)) {
                    $message[$field] = $value;
                } else {
                    $message['custom_fields'] .= " " . $field . ": " . $value . ";";
                }
            }
        }

        /* Send message and return the successful message */
        if ($message->save()) {
            return \Redirect::back()->
            with('msg', Lang::get('codeclutch.contact::lang.plugin.contact_form.success'));
        };
    }
}
