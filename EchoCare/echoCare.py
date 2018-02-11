from flask import Flask, render_template
from flask_ask import Ask, statement, question, session
from peewee import *
import smtplib
from email.mime.text import MIMEText
import yagmail
yagmail.register('derbyhacksechocare@gmail.com', 'derbyhacks318')
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
	
#def should_take_med(frequency, start_):

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

@ask.intent('AlertNurseIntent')
def alert_nurse_intent():
	nurse = ('1', 'Tracy Morgan', '5022943973', 'jacobcpawlak@gmail.com', '10:00 AM', '7:00PM', 'Lexington, KY')
	connection = connect_db()
	try:
		with connection.cursor() as cursor:
			query = 'SELECT * FROM nurses ORDER BY RAND() LIMIT 1'
			#query = 'SELECT * FROM nurses WHERE nurses.n_id = patient.n_id'
			cursor.execute(query)
			#nurse = cursor.fetchall()
			print(nurse)
			#query2 = 'SELECT * FROM patients WHERE patient.p_id == session.attributes[\'user_id\']';
	finally:
		connection.close()

	alert_nurse_response = render_template('alert_nurse', nurse = nurse)
	alert_nurse_response_reprompt = render_template('alert_nurse_reprompt', nurse = nurse)
	return question(alert_nurse_response).reprompt(alert_nurse_response_reprompt)


@ask.intent('EmailNurseIntent')
def email_nurse_intent():
	#fp = open('textfile', 'wb')
	#fp.write("Hello from Echo Care")
	#msg = MIMEText(fp.read())
	#fp.close()

	#msg = {}
	#msg['Subject'] = 'this worked?'
	#msg['From'] = 'jacobcpawlak@gmail.com'
	#msg['To'] = 'jacob.pawlak@uky.edu'

	#s = smtplib.SMTP('localhost')
	#s.sendmail('jacobcpawlak@gmail.com', ['jacob.pawlak@uky.edu'], msg.as_string())
	#s.quit()

	nurse = ('1', 'Tracy Morgan', '5022943973', 'jacobcpawlak@gmail.com', '10:00 AM', '7:00PM', 'Lexington, KY')

	print "You would get emailed if this worked"

	return statement(render_template('email_nurse', nurse = nurse))


@ask.intent('CallNurseIntent')
def call_nurse_intent():

	nurse = ('1', 'Tracy Morgan', '5022943973', 'jacobcpawlak@gmail.com', '10:00 AM', '7:00PM', 'Lexington, KY')

	print "You would get called if this worked"

	return statement(render_template('call_nurse', nurse = nurse))

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
