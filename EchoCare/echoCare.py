from flask import Flask, render_template
from flask_ask import Ask, statement, question, session
from peewee import *
import pymysql
from datetime import date

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


def connect_db():
	return pymysql.connect(host=db_info['hostname'], user=db_info['username'],
						   password=db_info['password'], db=db_info['database'])

def should_take_med(frequency, start_date):
	today = date.today()
	freq = int(frequency.split(' ')[0])
	delta = today - start_date
	if delta.days % freq == 0:
		return True
	else:
		return False
	
	

@ask.launch
def launch():
	greeting = render_template('greeting')
	repeat = render_template('greeting_reprompt')
#	return question(greeting).reprompt(repeat)
	return question(greeting)

@ask.intent('OneshotTideIntent')
def something():
	print "Something"
	return statement('YOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO')

@ask.intent('ListMedicationsIntent')
def list_medications():
	all_medications = ()
	connection = connect_db()
	try:
		with connection.cursor() as cursor:
			query = 'SELECT * FROM alerts INNER JOIN meds ON meds.m_id=alerts.m_id'
#			query = "SELECT meds.m_name " \
#					"FROM meds, conditions " \
#					"WHERE ...?"
			cursor.execute(query)
			all_medications = cursor.fetchall()
			print all_medications
	finally:
		connection.close()
	
	relavent_meds = []
	for item in all_medications:
		if should_take_med(item[2], item[1]):
			relavent_meds.append((item[7], item[9]))	# Name, amount

	medication_response = render_template('list_meds', meds = relavent_meds)
	return statement(medication_response)

@ask.intent('HowToTakeMedicationsIntent')
def list_medications():
	all_medications = ()
	connection = connect_db()
	try:
		with connection.cursor() as cursor:
			query = 'SELECT * FROM alerts INNER JOIN meds ON meds.m_id=alerts.m_id'
#			query = "SELECT meds.m_name " \
#					"FROM meds, conditions " \
#					"WHERE ...?"
			cursor.execute(query)
			all_medications = cursor.fetchall()
			print all_medications
	finally:
		connection.close()
	
	relavent_meds = []
	for item in all_medications:
		if should_take_med(item[2], item[1]):
			relavent_meds.append((item[7], item[8]))	# Name, amount

	medication_response = render_template('med_instructions', meds = relavent_meds)
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
