from flask import Flask, render_template
from flask-ask import Ask, statement, question
from EchoCare import app, ask, db, db_info
from peewee import *
import pymysql

DATABASE = 'sample.db'
USERNAME = 'admin'
PASSWORD = 'admin'
HOSTNAME = 'localhost'

db_info = { 'database': DATABASE,
			'username': USERNAME,
			'password': PASSWORD,
			'hostname': HOSTNAME }

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance
db = MySQLDatabase(DATABASE) # If we decide to use the ORM, we can update this later


@ask.launch
def launch():
	greeting = render_template('greeting')
	repeat = render_template('greeting_reprompt')
	return question(greeting).reprompt(repeat)

@ask.intent('MedicationQuestionIntent'):
	
