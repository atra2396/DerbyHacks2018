from flask import Flask, render_template
from flask_ask import Ask, statement, question, session
from peewee import *
import smtplib
from email.mime.text import MIMEText
import yagmail
# yagmail.register('derbyhacksechocare@gmail.com', 'derbyhacks318')
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
	if frequency == 'Daily':
		return True
	today = date.today()
	freq = int(frequency.split(' ')[0])
	delta = today - start_date
	if delta.days % freq == 0:
		return True
	else:
		return False

questions = []	# Holds the relevent questions; we'll pop one off each time the questions loop happens.

def get_questions():
	global questions
	questions = []
	all_question = ()
	connection = connect_db()
	try:
		with connection.cursor() as cursor:
			query = 'SELECT * FROM alerts INNER JOIN questions ON questions.q_id=alerts.q_id'
			cursor.execute(query)
			all_questions = cursor.fetchall()
			print all_questions
	finally:
		connection.close()
	
	for q in all_questions:
		if should_take_med(q[2], q[1]):		# In this case, should ask question.
			questions.append(q[-1])	# Just add the text.
	questions_length = len(questions)
	print questions


@ask.launch
def launch():
	greeting = render_template('greeting')
	repeat = render_template('greeting_reprompt')
#	return question(greeting).reprompt(repeat)
	return question(greeting)

all_responses = ''
@ask.intent('GetQuestionsIntent')
def get_all_questions():
	get_questions()
	if len(questions) == 0:
		return statement('You have no new questions.')
	print questions
	return question("You have some questions. First question: " + questions[0] + " Please begin your answers with, 'My answer is'...")

@ask.intent('AnswerQuestionsIntent')
def answer_questions(response):
	global questions
	global all_responses
	
	all_responses += questions.pop(0)
	all_responses += '\n' + response + '\n\n'

	if len(questions) > 0:
		return question("Thank you. Next question: " + questions[0])

	print all_responses

	yagmail.SMTP('derbyhacksechocare@gmail.com').send('jacobcpawlak@gmail.com', 'Your patient\'s answers', all_responses)
	return statement("Thank you, your responses have been mailed to your nurse.")

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
def medication_directions():
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
			cursor.execute(query)
			nurse = cursor.fetchall()
			print(nurse)
	finally:
		connection.close()

	alert_nurse_response = render_template('alert_nurse', nurse = nurse[0])
	alert_nurse_response_reprompt = render_template('alert_nurse_reprompt', nurse = nurse[0])
	return question(alert_nurse_response).reprompt(alert_nurse_response_reprompt)


@ask.intent('EmailNurseIntent')
def email_nurse_intent():

	yagmail.SMTP('derbyhacksechocare@gmail.com').send('jacobcpawlak@gmail.com', 'Your patient is requesting to see you', 'Please go check up on Jacob Pawlak, they are calling for your assistance from Echo Care')

	nurse = ('1', 'Tracy Morgan', '5022943973', 'jacobcpawlak@gmail.com', '10:00 AM', '7:00PM', 'Lexington, KY')

	print "You would get emailed if this worked"

	return statement(render_template('email_nurse', nurse = nurse))


@ask.intent('CallNurseIntent')
def call_nurse_intent():

	nurse = ('1', 'Tracy Morgan', '5022943973', 'jacobcpawlak@gmail.com', '10:00 AM', '7:00PM', 'Lexington, KY')

	yagmail.SMTP('derbyhacksechocare@gmail.com').send('jacobcpawlak@gmail.com', 'THIS SHOULD BE A PHONE CALL', 'This would normally be a phone call because the patient has sent out a high-urgency alert to you')

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
