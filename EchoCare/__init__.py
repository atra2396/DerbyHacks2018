from flask import Flask
from flask_ask import Ask

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance
