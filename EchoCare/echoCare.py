from flask import Flask, render_template, session
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

session.attributes['user'] = "Bob"
session.attributes['user_id'] = "0" 

def connect_db():
	return pymysql.connect(host=db_info['hostname'], user=db_info['username'],
						   password=db_info['password'], db=db_info['database'])

@ask.launch
def launch():
	greeting = render_template('greeting')
	repeat = render_template('greeting_reprompt')
	return question(greeting).reprompt(repeat)

@ask.intent('MedicationAlertIntent')
def get_medical_alerts():
	all_alerts = {}
	connection = connect_db()
	try:	# Get all med alerts for the day
		with connection.cursor() as cursor:
			query = "SELECT meds.m_name, DATE_FORMAT(alerts.time, '\%Y-\%m-\%d') " \
					"FROM meds INNER JOIN alerts ON meds.m_id=alerts " \
					"WHERE alerts.time LIKE CONCAT(CURDATE(), '%') AND alerts.p_id=%s"
			cursor.execute(query, (session.attributes['user_id']))
			all_alerts = cursor.fetchall()
	finally:
		connection.close()
