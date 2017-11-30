<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once __DIR__ . '/vendor/autoload.php';
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use App\remind;

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
        
        $user_id = $request['events'][0]['source']['userId'];

        if(strpos($text,'を登録') !== false){
            $this -> setTimetable($http_client, $bot, $reply_token, $text ,$user_id);
        } else {
            $message = '「~~~を登録」で「~~~」をリマインドするよ」';
            $bot->replyText($reply_token, $message);    
        }

    }

    function setTimetable($http_client, $bot, $reply_token, $text, $user_id){
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

    function reminedTimetable($http_client, $bot){

    }

    function update_last_message(){
        fopen("");
    }

    function save_remind($user_id, $data){

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
