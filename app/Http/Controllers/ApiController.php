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

        \Log::debug($request);

        //$events = file_get_contents('php://input');
        //$replyToken = explode('"',explode('replyToken":"', $events)[1])[0];

        $replyToken = $request['events'][0]['replyToken'];

//        \Log::debug("access: " + env('CHANNEL_ACCESS_TOKEN'));
//        \Log::debug("secret: " + env('CHANNEL_SECRET'));

//        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("hogehoge");        
        //$bot->replyText($events->event[0]['replyToken'], $textMessageBuilder);
        $bot->replyText($replyToken, "hogehoge");

    }
}
