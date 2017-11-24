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

        $httpClient = new CurlHTTPClient($access_token);
        $bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);

        \Log::debug($request['events']);

        $replyToken = $request['events'][0]['replyToken'];
        $message = $request['events'][0]['message']['text'];
        
        $temp = $bot->replyText($replyToken, $message);


    }
}
