from flask import render_template
from flask-ask import statement, question
from EchoCare import app, ask, db

@ask.launch
def launch():
	return statement('You\'re running the echoCare program.')


