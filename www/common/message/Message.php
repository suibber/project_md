<?php

use common\models\SysMessage;


class Message
{
    public function message($user_id, $title, $message)
    {
        $message = new SysMessage;
        $message->user_id = $user_id;
        $message->title = $title;
        $message->message = $message;
        $message->read_flag = false;
        $message->has_sent = true;
        $message->save();
    }
}
