<?php
namespace App\Traits;

use App\Traits\GenericHelperTrait;

trait TelegramTrait
{
    private $app_key = "5309267910:AAEAme-lvlUW_IPB1XJHHteKLnmE8JL4RTI";

    public function sendPhotoMessage($chat_id, $message, $image_url)
    {
        $post_fields = [
            "photo"=> $image_url,
            "caption"=> $message,
            "disable_notification"=> false,
            "reply_to_message_id"=> null,
            "chat_id"=> $chat_id
        ];

        $opt=array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$this->app_key.'/sendPhoto',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_fields),
            CURLOPT_HTTPHEADER => array(
              'accept: application/json',
              'content-type: application/json'
            ),
        );
        $this->nativeCurl($opt);
    }
}
