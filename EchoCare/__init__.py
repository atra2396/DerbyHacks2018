<<<<<<< HEAD
from flask import Flask
from flask_ask import Ask

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance
=======
from flask import Flask
from flask_ask import Ask
from peewee import MySQLDatabase

DATABASE = 'sample.db'

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance
db = MySQLDatabase(DATABASE)

from EchoCare import echoCare
>>>>>>> 86dcece446d47283c62bfb0010f3092283c4198b
