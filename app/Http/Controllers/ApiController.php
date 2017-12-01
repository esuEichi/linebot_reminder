<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once __DIR__ . '/vendor/autoload.php';
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

use App\remind;

class ApiController extends Controller
{
    //    
    function index(Request $request)
    {
        // LINE api 利用のためのパラメータを設定
        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');
        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);

        // ユーザーから受け取った情報を取得する
        $reply_token = $request['events'][0]['replyToken'];
        $text = $request['events'][0]['message']['text'];
        $user_id = $request['events'][0]['source']['userId'];

        // 条件分岐を行う
        if(strpos($text,'を登録') !== false){
            $this -> setRemind($http_client, $bot, $reply_token, $text ,$user_id);
        } else {
            $message = '「~~~を登録」で「~~~」をリマインドするよ」';
            $bot->replyText($reply_token, $message);    
        }

    }

    // リマインド用のメッセージを登録する
    function setRemind($http_client, $bot, $reply_token, $text, $user_id)
    {
        $save_text = explode('を登録',$text)[0];
        $arr = ['user_id' => $user_id, 'message' => $save_text];

        remind::insert(
            $arr
        );
        $bot->replyText($reply_token, "リマインド登録したよ");
    }

    // リマインドを実行する
    function remind()
    {
        $remind_data = remind::take(1)->get();
        \Log::debug($remind_data);
        $user_id = $remind_data[0]['user_id'];
        $message = $remind_data[0]['message'];
        \Log::debug($user_id);

        $this->push_message($user_id, $message);

    }


    // pushメッセージを送信する
    function push_message($user_id, $message)
    {
        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');
        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);
        $url = 'https://api.line.me/v2/bot/message/push';

        $push_message = new TextMessageBuilder($message);
        $push_message->buildMessage();

        $bot->pushMessage($user_id, $push_message);
    }

}
