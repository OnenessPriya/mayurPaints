<?php

use App\Models\Notification;
use App\Models\InvoiceRetailer;
use App\Models\Order;
use App\Models\Store;
use App\Models\State;
use App\Models\OrderDistributor;
use App\Models\Distributor;

$datetime = date('Y-m-d H:i:s');

if (!function_exists('in_array_r')) {
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if( ! $strict && is_string( $needle ) && ( is_float( $item ) || is_int( $item ) ) ) {
                $item = (string)$item;
            }
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    function in_array_r($item , $array){
        return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
    }
}

if(!function_exists('sendNotification')) {
    function sendNotification($sender, $receiver, $type, $route, $title, $body='')
    {
        $noti = new Notification();
        $noti->sender = $sender;
        $noti->receiver = $receiver;
        $noti->type = $type;
        $noti->route = $route;
        $noti->title = $title;
        $noti->body = $body;
        $noti->read_flag = 0;
        $noti->save();
    }
}

if(!function_exists('sendNotification')) {
    function sendNotification($sender, $receiver, $type, $route, $title, $body='')
    {
        $noti = new Notification();
        $noti->sender = $sender;
        $noti->receiver = $receiver;
        $noti->type = $type;
        $noti->route = $route;
        $noti->title = $title;
        $noti->body = $body;
        $noti->read_flag = 0;
        $noti->save();
    }
}


function CountSalesperson(){
    return User::where('type','2')->count();
}

function CountPainter(){
    return User::where('type','3')->count();
}
function CountProduct()
{
    return Product::count();
}




