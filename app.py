from flask import Flask, render_template
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.sql import text

app = Flask(__name__)

# change to name of your database; add path if necessary

app.config['MYSQL_HOST'] = 'BruhPC'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = 'password'
app.config['MYSQL_DB'] = 'fpsstatsstorage'

mysql = MySQL(app)

# this variable, db, will be used for all SQLAlchemy commands
db = SQLAlchemy(app)


@app.route("/")
def index():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM lietotāji")
    fetchdata = cur.fetchall()
    cur.close()

    return render_template('homepage.html', data = fetchdata)

@app.route("/stats")
def stats():
    return render_template('main.html')

if __name__ == '__main__':
    app.run(debug=True)