<?php

namespace Codeclutch\Contact\Components;

use Cms\Classes\ComponentBase;
use Codeclutch\Contact\Models\Message;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
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
        $settings = Settings::instance();

        /* Get custom fields for view */
        $this->page['custom_fields'] = $settings->custom_fields;

        /* Get receivers */
        if ($settings->is_receiver) {
            $this->page['receivers'] = $settings->receivers;
        }

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
        $custom_fields = Settings::instance()->custom_fields;
        if ($custom_fields) {
            foreach ($custom_fields as $field) {
                $received_data[$field['fields_name']] = Input::get($field['fields_name'], null);
            }
        }

        /* Create a new message model */
        $message = new Message();

        /* Create rules for validator */
        $rules = $message->rules;
        if ($custom_fields) {
            foreach (Settings::instance()->custom_fields as $field) {
                if ($field['is_required']) {
                    $rules[$field['fields_name']] = 'required';
                }
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
                    /* Create a textarea from custom fields */
                    $message['custom_fields'] .= $field . ': ' . $value . ' &#13;&#10;';
                }
            }
        }

        /*** Send message and return the successful message ***/

        /* Set vars array */
        $vars = [];
        foreach ($received_data as $key => $value) {
            $vars[$key] = $value;
        }

        /* Set the receiver */
        $settings = Settings::instance();
        if ($settings->is_receiver) {       /* Taking chosen receiver */
            $receiver_name = Input::get('receiver');
            $receivers = $settings->receivers;
            foreach ($receivers as $receiver) {
                if ($receiver['name'] == $receiver_name) {
                    $receiver_mail = $receiver['email'];
                }
            }
        } else {                            /* Taking the first receiver */
            $receiver_mail = $settings->receivers[0]['email'];
            $receiver_name = $settings->receivers[0]['name'];
        }

        /* Send message */
        if ($message->save()) {
            if (isset($receiver_mail)) {    /* Send message under condition receiver_mail is defined */
                Mail::send('codeclutch.contactform.message', $vars, function ($message) use (
                    $receiver_name,
                    $receiver_mail
                ) {
                    $message->to($receiver_mail, $receiver_name);
                });
            }
            return \Redirect::back()->
            with('msg', Lang::get('codeclutch.contact::lang.plugin.contact_form.success'));
        } else {
            return \Redirect::back()->
            with('msg', Lang::get('codeclutch.contact::lang.plugin.contact_form.error'));
        }
    }
}
