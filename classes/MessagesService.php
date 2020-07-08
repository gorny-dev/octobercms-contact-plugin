<?php
namespace Codeclutch\Contact\Classes;

use Codeclutch\Contact\Models\Message;

class MessagesService
{
    public static function countUnreadMessages()
    {
        return Message::where('is_read', 0)->count();
    }

}
