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


        for event in events:
            if isinstance(event, MessageEvent):
                text = event.message.text
                if text == '表單':
                    confirm_template = ConfirmTemplate(text='Do it?', actions=[
                        MessageTemplateAction(label='Yes', text='Yes!'),
                        MessageTemplateAction(label='No', text='No!'),
                    ])
                    template_message = TemplateSendMessage(
                       alt_text='Confirm alt text', template=confirm_template)
                    line_bot_api.reply_message(
                       event.reply_token,
                       template_message
                    )
                elif text == '按鈕':
                    buttons_template = ButtonsTemplate(
                        title='My buttons sample', text='Hello, my buttons', actions=[
                            URITemplateAction(
                                label='Go to line.me', uri='https://line.me'),
                            PostbackTemplateAction(label='ping', data='ping'),
                            PostbackTemplateAction(
                                label='ping with text', data='ping',
                                text='ping'),
                            MessageTemplateAction(label='Translate Rice', text='米')
                        ])
                    template_message = TemplateSendMessage(
                        alt_text='Buttons alt text', template=buttons_template)
                    line_bot_api.reply_message(event.reply_token, template_message)
                else:
                    line_bot_api.reply_message(
                        event.reply_token,
                       TextSendMessage(text=event.message.text)
                    )
        return HttpResponse()




import os
if __name__ == "__main__":
    app.run(host='0.0.0.0',port=os.environ['PORT'])
