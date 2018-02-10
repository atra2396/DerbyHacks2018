<<<<<<< HEAD
from flask import render_template
from flask-ask import statement, question
=======
from flask import render_template
from flask-ask import statement, question
from EchoCare import app, ask, db

@ask.launch
def launch():
	return statement('You\'re running the echoCare program.')


>>>>>>> 86dcece446d47283c62bfb0010f3092283c4198b
