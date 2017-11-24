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
        $httpClient = new CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);
        //\Log::debug("SECRET: ".var_dump(env('CHANNEL_SECRET')));
        //\Log::debug($replyToken = $request['events'][0]['replyToken']);
        
        $replyToken = $request['events'][0]['replyToken'];
        $temp = $bot->replyText($replyToken, "hogehoge");

        //\Log::debug($temp);

    }
}
