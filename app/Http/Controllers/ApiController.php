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

        $httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

        var_dump(getenv('CHANNEL_ACCESS_TOKEN'));
        var_dump(getenv('CHANNEL_SECRET'));
        var_dump($request['events'][0]['replyToken']);

        $replyToken = $request['events'][0]['replyToken'];
        $temp = $bot->replyText($replyToken, "hogehoge");

        \Log::debug(var_dump($temp));

    }
}
