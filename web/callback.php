<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'EHH8bCxOPmjOelZP4CkQfq2ZWQ3Ww2B4urQmOEUhTAHr55S2kpwZU8SjOKqPZwk2qL+uFmhmqsp8j0trp8RVDyVRyvgZ0X2691+jDbOkkyUKj0dNAvloZ0nJXux+Nr+S75akt+dUsCd+8N6zj263tAdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'fb668e65afe9234a56743aea40bfc610';
<?php

$accessToken = 'EHH8bCxOPmjOelZP4CkQfq2ZWQ3Ww2B4urQmOEUhTAHr55S2kpwZU8SjOKqPZwk2qL+uFmhmqsp8j0trp8RVDyVRyvgZ0X2691+jDbOkkyUKj0dNAvloZ0nJXux+Nr+S75akt+dUsCd+8N6zj263tAdB04t89/1O/w1cDnyilFU=';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);

$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

// 送られてきたメッセージの中身からレスポンスのタイプを選択
if ($message->{"text"} == '確認') {
    // 確認ダイアログタイプ
    $messageData = [
        'type' => 'template',
        'altText' => '確認ダイアログ',
        'template' => [
            'type' => 'confirm',
            'text' => '元気ですかー？',
            'actions' => [
                [
                    'type' => 'message',
                    'label' => '元気です',
                    'text' => '元気です'
                ],
                [
                    'type' => 'message',
                    'label' => 'まあまあです',
                    'text' => 'まあまあです'
                ],
            ]
        ]
    ];
} elseif ($message->{"text"} == 'ボタン') {
    // ボタンタイプ
    $messageData = [
        'type' => 'template',
        'altText' => 'ボタン',
        'template' => [
            'type' => 'buttons',
            'title' => 'タイトルです',
            'text' => '選択してね',
            'actions' => [
                [
                    'type' => 'postback',
                    'label' => 'webhookにpost送信',
                    'data' => 'value'
                ],
                [
                    'type' => 'uri',
                    'label' => 'googleへ移動',
                    'uri' => 'https://google.com'
                ]
            ]
        ]
    ];
} elseif ($message->{"text"} == 'カルーセル') {
    // カルーセルタイプ
    $messageData = [
        'type' => 'template',
        'altText' => 'カルーセル',
        'template' => [
            'type' => 'carousel',
            'columns' => [
                [
                    'title' => 'カルーセル1',
                    'text' => 'カルーセル1です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '美容の口コミ広場を見る',
                            'uri' => 'http://clinic.e-kuchikomi.info/'
                        ]
                    ]
                ],
                [
                    'title' => 'カルーセル2',
                    'text' => 'カルーセル2です',
                    'actions' => [
                        [
                            'type' => 'postback',
                            'label' => 'webhookにpost送信',
                            'data' => 'value'
                        ],
                        [
                            'type' => 'uri',
                            'label' => '女美会を見る',
                            'uri' => 'https://jobikai.com/'
                        ]
                    ]
                ],
            ]
        ]
    ];
} else {
    // それ以外は送られてきたテキストをオウム返し
    $messageData = [
        'type' => 'text',
        'text' => $message->{"text"}
    ];
}

$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData]
];
error_log(json_encode($response));

$ch = curl_init('https://api.line.me/v2/bot/message/reply');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
error_log($result);
curl_close($ch);
