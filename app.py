# encoding: utf-8
from flask import Flask, request, abort

from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import (
    MessageEvent, TextMessage, TextSendMessage,
)

app = Flask(__name__)


talk_api_key = config('r9O1mRLDv15gmaUeDuDElikmtuXtrL6g')
talk_api_key = ('r9O1mRLDv15gmaUeDuDElikmtuXtrL6g')
talk_api_key = config["r9O1mRLDv15gmaUeDuDElikmtuXtrL6g"]

line_bot_api = LineBotApi('EHH8bCxOPmjOelZP4CkQfq2ZWQ3Ww2B4urQmOEUhTAHr55S2kpwZU8SjOKqPZwk2qL+uFmhmqsp8j0trp8RVDyVRyvgZ0X2691+jDbOkkyUKj0dNAvloZ0nJXux+Nr+S75akt+dUsCd+8N6zj263tAdB04t89/1O/w1cDnyilFU=') #Your Channel Access Token
handler = WebhookHandler('fb668e65afe9234a56743aea40bfc610') #Your Channel Secret

@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']

    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)

    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        abort(400)

    return 'OK'

@handler.add(MessageEvent, message=TextMessage)
def handle_text_message(event):
    text = event.message.text #message from user
    apikey = talk_api_key #message from user



    data = urllib.parse.urlencode(data).encode("utf-8")
    with urllib.request.urlopen("https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk", data=data) as res:
        #response = res.read().decode("utf-8")
        reply_json = json.loads(res.read().decode("unicode_escape"))

        if reply_json['status'] == 0:
            reply = reply_json['results'][0]['reply']
            line_bot_api.reply_message(
                event.reply_token,
                TextSendMessage(text=reply))


#    line_bot_api.reply_message(
#        event.reply_token,
#        TextSendMessage(text=text)) #reply the same message from user


import os
if __name__ == "__main__":
    app.run(host='0.0.0.0',port=os.environ['PORT'])
