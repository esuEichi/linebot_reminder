<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once __DIR__ . '/vendor/autoload.php';
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;

class ApiController extends Controller
{
    //    
    function index(Request $request){

        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');

        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);

        \Log::debug($request['events']);

        $reply_token = $request['events'][0]['replyToken'];
        $text = $request['events'][0]['message']['text'];
        
        if($text === '登録'){
            $this -> setTimetable($http_client, $bot);
        } elseif($text === 'リマインド') {
            $this -> reminedTimetable();
        }
        $message = '「登録」で時間割の登録、「リマインド」で登録されている情報が確認できるよ';
        $bot->replyText($reply_token, $message);
    }

    function setTimetable($http_client, $bot, $reply_token){
        //$bot->replyText($)
    }

    function reminedTimetable($http_client, $bot){

    }

    function update_last_message(){

    }
    
    function remind(){

        $access_token = getenv('CHANNEL_ACCESS_TOKEN');
        $channel_secret = getenv('CHANNEL_SECRET');

        $http_client = new CurlHTTPClient($access_token);
        $bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);

        \Log::debug($request['events']);

        $reply_token = $request['events'][0]['replyToken'];
        $text = $request['events'][0]['message']['text'];
        $bot->replyText($reply_token, "リマインドapiが叩かれました");
    }

}
