
from flask import Flask, render_template, session, request, redirect, abort
from TokenGenerator import TokenGenerator

from pprint import pprint

# I am importing a sample data to verify. Users can setup a database and
# perform verification using SQLAlchemy

from sample_credentials import userData
from WebhookHelper import WebhookHelper

app = Flask(__name__)
app.config['SECRET_KEY'] = "15de2e5584da6716f650e3d50fa752cd"

@app.route("/")
def index():
    return "hello world"

@app.route("/login", methods=["POST","GET"])
def login():
    if request.method == "GET":
        return render_template("login.html")
    if (str(request.form["email"]) == userData.get("email")):
        token = TokenGenerator(userDetails=userData)
        return redirect(token.generateUrl())
    return redirect("/error/error occured")

@app.route("/checkout",methods=["POST"])
def checkoutDataWebhookEndpoint():
    if request.method == "POST":
        data = request.get_data()
        webhookHelper = WebhookHelper()
        verified = webhookHelper.verify_webhook(data, request.headers.get('X-Shopify-Hmac-SHA256'))
        if not verified:
            abort(401)

        print ("Received Data: \n")
        pprint(data,indent=4)
        return ('',200)

# @app.route("/proclogin", methods=["POST"])
# def procLogin():
#     if request.method == "POST":
#         user_list = user.functions.getUser().call()
#         for i in list(user_list):
#             if (str(i[0])==str(request.form["user_id"])):
#                 session["login_account"] = request.form["user_id"]
#                 session["login_name"] = i[1]
#                 print ("login success")
#                 return redirect("/userdashboard")
#         return redirect("/error/user not found")
#     return redirect("/error/Bad Request")

@app.route("/error/<error>")
def error_page(error):
    data = error
    return render_template("/error.html",data=data)


@app.route("/test")
def tokenRoute():
    token = TokenGenerator({"email":"jkhan266@gmail.com"})
    print (token.generateUrl())
    return "Success"


if __name__ == "__main__":
    app.run(debug=True)