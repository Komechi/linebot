<?php

//ユーザーからのメッセージ取得


//メッセージ以外のときは何も返さず終了


//返信データ作成
require_once('./LINEBotTiny.php');
$channelAccessToken = 'EHH8bCxOPmjOelZP4CkQfq2ZWQ3Ww2B4urQmOEUhTAHr55S2kpwZU8SjOKqPZwk2qL+uFmhmqsp8j0trp8RVDyVRyvgZ0X2691+jDbOkkyUKj0dNAvloZ0nJXux+Nr+S75akt+dUsCd+8N6zj263tAdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'fb668e65afe9234a56743aea40bfc610';
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $request = $message['text'];
                    switch ($message['text']) {
                        case '你好':
                            $request = "你好啊!";
                            break;

                        case '可以自我介紹嗎':
                            $request = "可以啊!我是小樁，現在12歲囉! 最喜歡的食物是草莓大福喔";
                            break;
                        case '要不要吃棒棒糖':
                            $request = "我要叫警察囉::>__<::";
                            break;
                        case '最喜歡誰呢':
                            $request = "製作出我的邊緣人哥哥";
                            break;
                        case '我喜歡妳':
                            $request = "我也是♥";
                            break;
                        default:
                            $request = print_r($event);
                            break;
                    }
                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $request
                            )
                        )
                    ));
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
