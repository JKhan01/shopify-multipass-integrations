
import base64
import hashlib
import hmac
from dotenv import load_dotenv
import os

load_dotenv()

API_SECRET_KEY = os.environ['WEBHOOK_APP_API_SECRET_KEY']

class WebhookHelper:
    def verify_webhook(self, data, hmac_header):
        digest = hmac.new(API_SECRET_KEY.encode('utf-8'), data, digestmod=hashlib.sha256).digest()
        computed_hmac = base64.b64encode(digest)

        return hmac.compare_digest(computed_hmac, hmac_header.encode('utf-8'))
