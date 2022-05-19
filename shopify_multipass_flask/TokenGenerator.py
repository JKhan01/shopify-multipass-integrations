import hashlib
from typing import Dict
from dotenv import load_dotenv
import os

import datetime
import json
from Crypto.Cipher import AES
from Crypto.Hash import SHA256, HMAC
from Crypto.Random import get_random_bytes
from base64 import urlsafe_b64encode


load_dotenv()
SHOPIFY_MULTIPASS_SECRET = os.environ["SHOPIFY_MULTIPASS_TOKEN"]
SHOPIFY_STORE_URL = os.environ["SHOPIFY_STORE_URL"]

print (SHOPIFY_MULTIPASS_SECRET + "\n"+ SHOPIFY_STORE_URL +"\n")
class TokenGenerator:
    def __init__(self, userDetails:Dict) -> None:
        tokenHash = hashlib.sha256(SHOPIFY_MULTIPASS_SECRET.encode('utf-8')).digest()
        self.encryptionKey = tokenHash[0:16]
        self.signatureKey = tokenHash[16:]
        self.customerDataHash = userDetails

    def __generateToken(self):
        self.customerDataHash['created_at'] = datetime.datetime.utcnow().isoformat()
        cipherText = self.__encrypt(json.dumps(self.customerDataHash))
        return urlsafe_b64encode(cipherText + self.__sign(cipherText))

    def generateUrl(self) -> str:
        return f"{SHOPIFY_STORE_URL}/account/login/multipass/{self.__generateToken().decode('utf-8')}"

    def __encrypt(self, plainText):
        plainText = self.__pad(plainText)
        iv = get_random_bytes(AES.block_size)
        cipher = AES.new(self.encryptionKey, AES.MODE_CBC, iv)
        return iv + cipher.encrypt(plainText.encode('utf-8'))

    def __sign(self, secret):
        return HMAC.new(self.signatureKey, secret, SHA256).digest()

    def __pad(self, s):
        return s + (AES.block_size - len(s) % AES.block_size) * chr(AES.block_size - len(s) % AES.block_size)