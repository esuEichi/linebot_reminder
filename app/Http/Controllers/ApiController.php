<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once __DIR__ . '/vendor/autoload.php';
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MassageBuilder;
use \LINE\LINEBot;
use App\remind;

class ApiController extends Controller
{
    //    
    function index(Request $request)
    {
        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');

        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);

        \Log::debug($request['events']);

        $reply_token = $request['events'][0]['replyToken'];
        $text = $request['events'][0]['message']['text'];
        
        $user_id = $request['events'][0]['source']['userId'];

        if(strpos($text,'を登録') !== false){
            $this -> setTimetable($http_client, $bot, $reply_token, $text ,$user_id);
        } else {
            $message = '「~~~を登録」で「~~~」をリマインドするよ」';
            $bot->replyText($reply_token, $message);    
        }

    }

    function setTimetable($http_client, $bot, $reply_token, $text, $user_id)
    {
        //$bot->replyText($)
        $save_text = explode('を登録',$text)[0];
        $arr = ['user_id' => $user_id, 'message' => $save_text];
        \Log::debug($arr);
        
        remind::insert(
            $arr
        );
        $bot->replyText($reply_token, "リマインド登録したよ");
        $debug_db = remind::take(10)->get();
        \Log::debug("---hogehogehogehoge---------------------------");
        \Log::debug($debug_db);
    }


    function remind()
    {
        $remind_data = remind::take(1)->get();
        \Log::debug($remind_data);
        $user_id = $remind_data[0]['user_id'];
        $message = $remind_data[0]['message'];
        \Log::debug($user_id);

        $this->push_message($user_id, $message);

    }

    function push_message($user_id, $message)
    {
        \Log::debug("push_message");
        \Log::debug($user_id);
        \Log::debug($message);
        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');
        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);
        $url = 'https://api.line.me/v2/bot/message/push';

        $push_message = new MessageBuilder($message);
        $push_message->buildMessage();

        $bot->pushMessage($user_id, $push_message);
/*
        // ヘッダーの作成
        $headers = array('Content-Type: application/json',
        'Authorization: Bearer ' . $access_token);
        \Log::debug($headers);

        $body = json_encode(
            array(
                'to' => $user_id,
                'messages'=> 
                    array(
                        'type' => 'text', 
                        'text' => $message)
            )); 
        \Log::debug($body);
            

        // 送り出し用
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $body
        );
        \Log::debug($options);
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        \Log::debug($curl);
        curl_exec($curl);
        curl_close($curl);
*/
    }

}
