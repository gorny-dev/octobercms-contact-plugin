<?php namespace Codeclutch\Contact\Models;

use Model;
use Lang;

/**
 * Model
 */
class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $table = 'codeclutch_contact_messages';


    public $rules = [
        'name' => 'required|min:4|max:30',
        'email' => 'required|email',
        'content' => 'required|min:20|max:500'
    ];
}
