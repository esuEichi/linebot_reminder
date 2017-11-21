<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//require_once __DIR__ . '/vendor/autoload.php';
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;

class ApiController extends Controller
{
    //
    function index(){
        $httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
        //$sign = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
        \Log::debug(file_get_contents('php://input'));

        $events = json_decode(file_get_contents('php://input'));
        /*
        foreach ($events as $event) {
            if (!($event instanceof \LINE\LINEBot\Event\MessageEvent) ||
            !($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
                continue;
            }
        
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("hogehoge");        
            $bot->replyText($event->getReplyToken(), $textMessageBuilder);

        }*/
        \Log::debug(var_dump($events));
        $events->event[0]['replyToken'];
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("hogehoge");        
        //$bot->replyText($events->event[0]['replyToken'], $textMessageBuilder);
        $bot->replyText($events->event[0]['replyToken'], "hogehoge");

    }
}
