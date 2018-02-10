from flask import Flask
from flask_ask import Ask
from peewee import MySQLDatabase

DATABASE = 'sample.db'

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance
db = MySQLDatabase(DATABASE)

from EchoCare import echoCare
