from flask import Flask, render_template, session
from flask_ask import Ask, statement, question
from peewee import *
import pymysql

DATABASE = 'echo_care'
USERNAME = 'EchoCare'
PASSWORD = 'derbyhacks318'
HOSTNAME = 'derbyhacks3.c9fsslvm81yn.us-east-2.rds.amazonaws.com'

db_info = { 'database': DATABASE,
			'username': USERNAME,
			'password': PASSWORD,
			'hostname': HOSTNAME }

app = Flask(__name__)	# Define app instance
ask = Ask(app, "/")		# flask-ask instance

# session.attributes['user'] = "Bob"
# session.attributes['user_id'] = "0" 

def connect_db():
	return pymysql.connect(host=db_info['hostname'], user=db_info['username'],
						   password=db_info['password'], db=db_info['database'])

def should_take_med(frequency, start_):
	

@ask.launch
def launch():
	greeting = render_template('greeting')
	repeat = render_template('greeting_reprompt')
#	return question(greeting).reprompt(repeat)
	return statement(greeting)

@ask.intent('OneshotTideIntent')
def something():
	print "Something"
	return statement('YOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO')

@ask.intent('ListMedicationsIntent')
def list_medications():
	medications = ()
	connection = connect_db()
	try:
		with connection.cursor() as cursor:
			query = 'SELECT * FROM meds'
#			query = "SELECT meds.m_name " \
#					"FROM meds, conditions " \
#					"WHERE ...?"
			cursor.execute(query)
			medications = cursor.fetchall()
			print medications
	finally:
		connection.close()
	
	medication_response = render_template('list_meds', meds = medications)
	return statement(medication_response)
			

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

if __name__ == '__main__':
	app.run(debug=True)
